var baseHost = window.location.hostname;
var baseEndpoint = 'http://' + baseHost;


var RELAY_STATE_MESSAGE = 10;


function relayButton(id, name, state, onChange) {
  var self = this;

  self.id = ko.observable(id);
  self.name = ko.observable(name);
  self.state = ko.observable(state);

  self.state.subscribe(function(newValue) {
    onChange(self, newValue);
  });
}

function BaseViewModel(defaults, remoteUrl, mappings) {
  if (mappings === undefined) {
    mappings = {};
  }
  var self = this;
  self.remoteUrl = remoteUrl;

  ko.mapping.fromJS(defaults, mappings, self);
  self.fetching = ko.observable(false);
}

BaseViewModel.prototype.update = function(after) {
  if (after == undefined) {
    after = function() {};
  }
  var self = this;
  self.fetching(true);
  $.get(self.remoteUrl, function(data) {
    ko.mapping.fromJS(data, self);
  }, 'json').always(function() {
    self.fetching(false);
    after();
  });
};

function StatusViewModel() {
  var self = this;

  BaseViewModel.call(self, {
    "relay_1_state": false,
    "relay_2_state": false,
    "relay_3_state": false,
    "relay_4_state": false
  }, 'http://192.168.1.8' + '/status');
   
}
StatusViewModel.prototype = Object.create(BaseViewModel.prototype);
StatusViewModel.prototype.constructor = StatusViewModel;

function StatusViewModel2() {
  var self = this;

  BaseViewModel.call(self, {
    "dht_temperature": "",
    "dht_humidity": "",
    "rip_motion": "",
    "db_temperature": ""
  }, baseEndpoint + '/status_sensors');
   
}
StatusViewModel2.prototype = Object.create(BaseViewModel.prototype);
StatusViewModel2.prototype.constructor = StatusViewModel2;


function ConfigViewModel() {
  var self = this;

  BaseViewModel.call(self, {
    "relay_1_name": "DOOR",
    "relay_2_name": "A.C",
    "relay_3_name": "LIGHT 1",
    "relay_4_name": "LIGHT 2"
  }, "http://192.168.1.8" + '/config');
}
ConfigViewModel.prototype = Object.create(BaseViewModel.prototype);
ConfigViewModel.prototype.constructor = ConfigViewModel;

function LastValuesViewModel() {
  var self = this;
  self.remoteUrl = baseEndpoint + '/lastvalues';

  self.fetching = ko.observable(false);
  self.values = ko.mapping.fromJS([]);

  self.update = function(after) {
    if (after == undefined) {
      after = function() {};
    }
    var self = this;
    self.fetching(true);
    $.get(self.remoteUrl, function(data) {
      var namevaluepairs = data.split(",");
      var vals = [];
      for (var z in namevaluepairs) {
        var namevalue = namevaluepairs[z].split(":");
        var units = "";
        if (namevalue[0].indexOf("H") === 0) units = String.fromCharCode(37);
        if (namevalue[0].indexOf("T1") === 0) units = String.fromCharCode(176) + "C";
        if (namevalue[0].indexOf("T2") === 0) units = String.fromCharCode(176) + "C";
        vals.push({
          key: namevalue[0],
          value: namevalue[1] + units
        });
      }
      ko.mapping.fromJS(vals, self.values);
    }, 'text').always(function() {
      self.fetching(false);
      after();
    });
  };
}







function MainViewModel() {
  var self = this;

  self.status = new StatusViewModel();
  self.status2 = new StatusViewModel2();
  self.config = new ConfigViewModel();
  self.last = new LastValuesViewModel();
 
  self.initialised = ko.observable(false);
  self.updating = ko.observable(false);



  //Latest data cookie set
  self.latest_data_enabled = ko.observable(false);
  self.latest_data_enabled.subscribe(function(val){
    self.setCookie("latest_data_enabled", val.toString());
  });

  var updateTimer = null;
  var updateTime = 1 * 1000;

  //Relay slider switches
  self.availableRelays = ko.observableArray([]);
  self.activeRelays = ko.pureComputed(function() {
    return self.availableRelays().filter(function(relay) {
      return relay.state();
    });
  });

  // Log changes to the console
  self.activeRelays.subscribe(function(sel) {
    console.log("Active Relays are: " + sel.map(function(s) {
      return s.name();
    }).join(", "));
  });

  // Log the individual that caused the change
  self.onRelayStateChange = function(item, newValue) {
    console.log("State chnage event: " + item.name() + "(" + newValue + ")");
  };


  // -----------------------------------------------------------------------
  // Initialise the app
  // -----------------------------------------------------------------------
  self.start = function() {
    self.updating(true);
    self.config.update(function() {
      self.status.update(function() {
        self.status2.update(function() {
        self.last.update(function() {
          self.init(function() {
            self.connect();
            //set the logs and latest data modes from cookies
            self.latest_data_enabled(self.getCookie("latest_data_enabled", "false") === "true" );
            self.logs_enabled(self.getCookie("logs_enabled", "false") === "true" );
            self.initialised(true);
            updateTimer = setTimeout(self.update, updateTime);
            self.updating(false);
          });
        });
      });//
    });
    });
  };

  // -----------------------------------------------------------------------
  // Initialise graph and relay slider switches
  // -----------------------------------------------------------------------
  self.init = function(after) {
    if (after == undefined) {
      after = function() {};
    }
    
    self.availableRelays([
      new relayButton(1, self.config.relay_1_name(), self.status.relay_1_state(), self.onRelayStateChange),
      new relayButton(2, self.config.relay_2_name(), self.status.relay_2_state(), self.onRelayStateChange),
      new relayButton(3, self.config.relay_3_name(), self.status.relay_3_state(), self.onRelayStateChange),
      new relayButton(4, self.config.relay_4_name(), self.status.relay_4_state(), self.onRelayStateChange),
    ]);
    after();
  };

  // -----------------------------------------------------------------------
  // Get the updated state from the ESP
  // -----------------------------------------------------------------------
  self.update = function() {
    if (self.updating()) {
      return;
    }
    self.updating(true);
    if (null !== updateTimer) {
      clearTimeout(updateTimer);
      updateTimer = null;
    }
    self.status.update(function() {
      self.status2.update(function() {
      self.refreshRelayStates();
    });
  });//
   
  };

  self.refreshRelayStates = function() {
    self.availableRelays()[0].state(self.status.relay_1_state());
    self.availableRelays()[1].state(self.status.relay_2_state());
    self.availableRelays()[2].state(self.status.relay_3_state());
    self.availableRelays()[3].state(self.status.relay_4_state());
    
  };

  // -----------------------------------------------------------------------
  // Event: Relay Switch CLick
  // -----------------------------------------------------------------------
  self.onSwitchClick = function(item) {
    console.log(ko.unwrap(item.state()));
    self.sendRelayMsg(item, item.state());
    return true;
  };

  // -----------------------------------------------------------------------
  // Websocket
  // -----------------------------------------------------------------------
  self.pingInterval = false;
  self.reconnectInterval = false;
  self.socket = false;
  self.wsEndpoint = "ws://" + "192.168.1.8" + '/ws';

  self.connect = function() {
    self.socket = new WebSocket(self.wsEndpoint);
    self.socket.onopen = function(ev) {
      self.pingInterval = setInterval(function() {
        self.socket.send("{\"ping\":1}");
      }, 1000);
    };
    self.socket.onclose = function(ev) {
      self.reconnect();
    };
    self.socket.onmessage = function(msg) {
      console.log(msg);
    };
    self.socket.onerror = function(ev) {
      console.log(ev);
      self.socket.close();
      self.reconnect();
    };
    self.reconnect = function() {
      if (false !== self.pingIntert) {
        clearInterval(self.pingInterval);
        self.pingInterval = false;
      }
      if (false === self.reconnectInterval) {
        self.reconnectInterval = setTimeout(function() {
          self.reconnectInterval = false;
          self.connect();
        }, 500);
      }
    };
  };

  // -----------------------------------------------------------------------
  // Websockets relay message
  // -----------------------------------------------------------------------
  self.sendRelayMsg = function(relay, state) {
    var msg = {
      type: RELAY_STATE_MESSAGE,
      id: relay.id(),
      name: relay.name(),
      state: !state
    };
    console.log(JSON.stringify(msg));
    self.socket.send(JSON.stringify(msg));
  };

  self.sendRelayEvent = function(relay, state) {
    var msg = {
      type: RELAY_STATE_MESSAGE,
      id: relay.id(),
      name: relay.name(),
      state: state
    };
    console.log(JSON.stringify(msg));
    self.socket.send(JSON.stringify(msg));
  };
  // -----------------------------------------------------------------------
  // Cookie management, based on https://www.w3schools.com/js/js_cookies.asp
  // -----------------------------------------------------------------------
  self.setCookie = function(cname, cvalue, exdays = false) {
    var expires = "";
    if (false !== exdays) {
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      expires = ";expires=" + d.toUTCString();
    }
    document.cookie = cname + "=" + cvalue + expires + ";path=/";
  };

  self.getCookie = function(cname, def = "") {
    var name = cname + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) === " ") {
        c = c.substring(1);
      }
      if (c.indexOf(name) === 0) {
        return c.substring(name.length, c.length);
      }
    }
    return def;
  };

}

$(function() {
  var vm = new MainViewModel();
  ko.applyBindings(vm);
  vm.start();
});
