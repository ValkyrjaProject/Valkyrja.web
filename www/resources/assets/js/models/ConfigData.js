import {EmptyData} from "./EmptyData";

export class ConfigData {
    id;
    value; // either value of field or a list of ConfigData instances
    original_value = EmptyData.singleton();
    error_data; // Same ErrorData createInstance as in ConfigErrors

    /**
     * @param id
     * @param value
     * @returns {this}
     */
    static instanceFromApi(id, value) {
        let configData = new this;
        configData.id = id;
        configData.value = value;
        configData.original_value = _.cloneDeep(value);
        return configData;
    }

    /**
     * @param id
     * @param value
     * @returns {this}
     */
    static newInstance(id, value) {
        let configData = new this;
        configData.id = id;
        configData.value = value;
        return configData;
    }

    getChanged() {
        let returnArr = {};
        if (this.value instanceof ConfigData) {
            let changed = this.value.getChanged();
            if (changed) {
                returnArr[this.id] = changed;
            }
        }
        else if (this.value instanceof Array) {
            let objArr = {};
            for (let i = 0; i < this.value.length; i++) {
                if (this.value[i] instanceof ConfigData) {
                    let changed = this.value[i].getChanged();
                    if (changed && changed[this.value[i].id]) {
                        objArr[this.value[i].id] = changed[this.value[i].id];
                    }
                }
            }
            if (!_.isEmpty(objArr)) {
                returnArr[this.id] = objArr;
            }
        }
        else if (this.value instanceof Object) {
            for (let field of Object.keys(this.value)) {
                if (this.value[field] instanceof ConfigData) {
                    let changed = this.value[field].getChanged();
                    if (changed && changed[this.id]) {
                        returnArr[this.id] = changed[this.id];
                        break;
                    }
                }
                else if (this.original_value instanceof EmptyData && this.value[field] || this.value[field] !== this.original_value[field]) {
                    returnArr[this.id] = {...this.value};
                    break;
                }
            }
        }
        else if (this.original_value instanceof EmptyData && this.value) {
            returnArr[this.id] = this.value;
        }
        else if (this.value !== this.original_value && this.value) {
            returnArr[this.id] = this.value;
        }
        return returnArr;
    }

    /**
     * @returns {string} value or empty string if null
     */
    toString() {
        return this.value !== null ? this.value.toString() : "";
    }
}
