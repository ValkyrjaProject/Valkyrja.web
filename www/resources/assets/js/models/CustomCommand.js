import {ConfigData} from "./ConfigData";
import {Config} from "./Config";

/**
 * Custom Commands allows people to execute commands set by the user.
 * It responds with pre-set text, which can be useful for letting
 * people know about certain topics.
 */
export class CustomCommand extends ConfigData {
    /**
     * Returns new instance with default values
     * @param commandid ID of command to execute
     * @returns {this}
     */
    static newInstance(commandid = "") {
        let command = new this;
        command.id = commandid;
        command.value = {
            commandid: commandid,
            response: "",
            description: ""
        };
        return command;
    }

    get command_id() {
        return this.value["commandid"];
    }

    set command_id(value) {
        this.id = value;
        this.value["commandid"] = value;
    }

    get response() {
        return this.value["response"].toString();
    }

    set response(value) {
        this.value["response"] = value;
    }

    get description() {
        return this.value["description"].toString();
    }

    set description(value) {
        this.value["description"] = value;
    }

    toString() {
        return this.command_id;
    }
}

export class CustomCommandFactory {
    /**
     * @param {Array} values
     * @returns {Array<CustomCommand>}
     */
    static getConfigData(values) {
        let config_data = [];
        for (let i in values) {
            if (values[i] instanceof Array) {
                config_data.push(Config.getConfigData(values[i]));
            }
            else {
                /** @type {CustomCommand} */
                let command = CustomCommand.instanceFromApi(values[i]["commandid"], values[i]);
                config_data.push(command);
            }
        }
        return config_data;
    }
}
