

// Set Color Brightness to Valid Value
int colorBright ( int bri ) {
	int bright = bri;
	
  	if (bright <= 4) {
    	bright = 4;
	} else if (bright <= 8) {
    	bright = 8;
	} else if (bright <= 12) {
    	bright = 12;
	} else if (bright <= 15) {
    	bright = 15;
	} else if (bright <= 19) {
    	bright = 19;
	} else if (bright <= 23) {
    	bright = 23;
	} else if (bright <= 27) {
    	bright = 27;
	} else if (bright <= 31) {
    	bright = 31;
	} else if (bright <= 35) {
    	bright = 35;
	} else if (bright <= 39) {
    	bright = 39;
	} else if (bright <= 42) {
    	bright = 42;
	} else if (bright <= 46) {
    	bright = 46;
	} else if (bright <= 50) {
    	bright = 50;
	} else if (bright <= 54) {
    	bright = 54;
	} else if (bright <= 58) {
    	bright = 58;
	} else if (bright <= 62) {
    	bright = 62;
	} else if (bright <= 65) {
    	bright = 65;
	} else if (bright <= 69) {
    	bright = 69;
	} else if (bright <= 73) {
    	bright = 73;
	} else if (bright <= 77) {
    	bright = 77;
	} else if (bright <= 81) {
    	bright = 81;
	} else if (bright <= 85) {
    	bright = 85;
	} else if (bright <= 88) {
    	bright = 88;
	} else if (bright <= 92) {
    	bright = 92;
	} else if (bright <= 96) {
    	bright = 96;
	} else if (bright <= 100) {
	    bright = 100;
	} else {
		bright = 100;
	}
  
	return bright;
}

// Set White Brightness To Valid Value
int whiteBright( int bri ) {
	int bright = bri;
	if (bright <= 9) {
	    bright = 9;
	} else if (bright <= 18) {
    	bright = 18;
  	} else if (bright <= 27) {
   	 	bright = 27;
  	} else if (bright <= 36) {
    	bright = 36;
  	} else if (bright <= 45) {
    	bright = 45;
  	} else if (bright <= 54) {
    	bright = 54;
  	} else if (bright <= 63) {
    	bright = 63;
  	} else if (bright <= 72) {
    	bright = 72;
  	} else if (bright <= 81) {
    	bright = 81;
  	} else if (bright <= 90) {
    	bright = 90;
  	} else if (bright <= 100) {
    	bright = 100;
  	} else {
		bright = 100;
  	}
	return bright;
}

// Increment Transmission Number Between 0 and 255
int IncrementTransmissionNum( int number ){
	int trans = number + 1;

	if (trans >= 256) {
		trans = trans - 256;
	}
	return trans;
}