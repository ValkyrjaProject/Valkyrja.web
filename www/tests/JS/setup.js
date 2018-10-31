let sinon = require("sinon");
let loglevel = require("loglevel");

require("jsdom-global")();

global.log = sinon.stub(loglevel);
