var method = command.prototype;

function command(type, add1, add2, key, bri, datetime) {
    this._type = type;
    this._add1 = add1;
    this._add2 = add2;
    this._key = key;
    this._bri = bri;
    this._datetime = new Date(datetime);
}

method.getDatetime = function() {
    return this._datetime;
};

method.getType = function() {
    return this._type;
};

method.getKey = function() {
    return this._key;
};

method.getBrightness = function() {
    return this._bri;
};

method.getAddress1 = function() {
    return this._add1;
};

method.getAddress2 = function() {
    return this._add2;
};

method.isOlder(millisecond) {
    var currentms = (new Date).getTime();
    var commandms = (this._datetime).getTime();
    
    if ( ( currentms - commandms ) =< millisecond ) { 
       return false;
    } else {
       return true;
    }
};
    
module.exports = command;