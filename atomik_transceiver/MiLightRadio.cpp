/*
 * MiLightRadio.cpp
 *
 *  Created on: 29 May 2015
 *      Author: henryk
 */

#include "MiLightRadio.h"

#define PACKET_ID(packet) ( ((packet[1] & 0xF0)<<24) | (packet[2]<<16) | (packet[3]<<8) | (packet[7]) )
static int radioMode = 0;  //White = 2 , RGBW = 1;
static uint8_t CHANNELS[3]; 

#define NUM_CHANNELS (sizeof(CHANNELS)/sizeof(CHANNELS[0]))

MiLightRadio::MiLightRadio(AbstractPL1167 &pl1167)
  : _pl1167(pl1167) {
  _waiting = false;
}

int MiLightRadio::begin()
{
  if (radioMode == 0) {
    radioMode = 1;
  }
  
  int retval = _pl1167.open();
  if (retval < 0) {
    return retval;
  }

  retval = _pl1167.setCRC(true);
  if (retval < 0) {
    return retval;
  }

  retval = _pl1167.setPreambleLength(3);
  if (retval < 0) {
    return retval;
  }

  retval = _pl1167.setTrailerLength(4);
  if (retval < 0) {
    return retval;
  }
  
  if (radioMode == 1) {
  CHANNELS[0] = 9;
  CHANNELS[1] = 40;
  CHANNELS[2] = 71;
  // RGBW Channels  {9, 40, 71}; 

    retval = _pl1167.setSyncword(0x147A, 0x258B);    // RGBW Syncword
    if (retval < 0) {
      return retval;
    }
  }
  
  if (radioMode == 2) {
   CHANNELS[0] = 4;
  CHANNELS[1] = 39;
  CHANNELS[2] = 74;
  // White Channels  {4, 39, 74};   
    retval = _pl1167.setSyncword(0x050A, 0x55AA);      // White Syncword
    if (retval < 0) {
      return retval;
    }
  }

  retval = _pl1167.setMaxPacketLength(8);
  if (retval < 0) {
    return retval;
  }

  available();

  return 0;
}

int MiLightRadio::getRadioMode()
{
    return radioMode;
}

void MiLightRadio::setRadioMode(int mode)
{
    if (radioMode == mode) {
      return;
    } else {
      radioMode = mode;
      begin();
    }
}

bool MiLightRadio::available()
{
  if (_waiting) {
    return true;
  }

  if (_pl1167.receive(CHANNELS[0]) > 0) {
    size_t packet_length = sizeof(_packet);
    if (_pl1167.readFIFO(_packet, packet_length) < 0) {
      return false;
    }
    if (packet_length == 0 || packet_length != _packet[0] + 1U) {
      return false;
    }

    uint32_t packet_id = PACKET_ID(_packet);
    if (packet_id == _prev_packet_id) {
      _dupes_received++;
    } else {
      _prev_packet_id = packet_id;
      _waiting = true;
    }
  }

  return _waiting;
}

int MiLightRadio::dupesReceived()
{
  return _dupes_received;
}


int MiLightRadio::read(uint8_t frame[], size_t &frame_length)
{
  if (!_waiting) {
    frame_length = 0;
    return -1;
  }

  if (frame_length > sizeof(_packet) - 1) {
    frame_length = sizeof(_packet) - 1;
  }

  if (frame_length > _packet[0]) {
    frame_length = _packet[0];
  }

  memcpy(frame, _packet + 1, frame_length);
  _waiting = false;

  return _packet[0];
}

int MiLightRadio::write(uint8_t frame[], size_t frame_length)
{
  if (frame_length > sizeof(_out_packet) - 1) {
    return -1;
  }

  memcpy(_out_packet + 1, frame, frame_length);
  _out_packet[0] = frame_length;

  int retval = resend();
  if (retval < 0) {
    return retval;
  }
  return frame_length;
}

int MiLightRadio::resend()
{
  for (size_t i = 0; i < NUM_CHANNELS; i++) {
    _pl1167.writeFIFO(_out_packet, _out_packet[0] + 1);
    _pl1167.transmit(CHANNELS[i]);
  }
  return 0;
}
