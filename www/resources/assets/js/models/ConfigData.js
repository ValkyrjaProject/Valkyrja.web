export class ConfigData {
    id;
    value; // either value of field or a list of ConfigData instances
    original_value;
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
        configData.original_value = value;
        return configData;
    }

    /**
     * @returns {boolean} if value has changed since createInstance was created.
     */
    hasChanged() {
        return this.value === this.original_value;
    }

    /**
     * @returns {string} value or empty string if null
     */
    toString() {
        return this.value !== null ? this.value.toString() : "";
    }
}
