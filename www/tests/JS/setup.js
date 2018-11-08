let sinon = require("sinon");
let loglevel = require("loglevel");
let chai = require("chai");
let chaiAsPromised = require("chai-as-promised");

chai.use(chaiAsPromised);
require("jsdom-global")();

global.log = sinon.stub(loglevel);
