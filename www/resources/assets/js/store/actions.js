import configData from "../api/configData";
import {ADD_CONFIG, ADD_GUILDS, ADD_USER, API_ERROR, CHANGE_CONFIG, INITIALIZE_USER} from "./mutation_types";

export const retrieveGuilds = ({commit}) => {
    return new Promise((resolve, reject) => {
        configData.getGuilds()
            .then(response => {
                commit(ADD_GUILDS, response.data);
                resolve();
            })
            .catch(error => {
                commit(API_ERROR, error["response"]["data"]);
                reject();
            });
    });
};

export const retrieveConfig = ({commit}, serverId) => {
    return new Promise((resolve, reject) => {
        configData.getServerConfig(serverId)
            .then(response => {
                commit(ADD_CONFIG, response.data);
                resolve();
            })
            .catch(error => {
                commit(API_ERROR, error["response"]["data"]);
                reject();
            });
    });
};

export const retrieveUser = ({commit}) => {
    return new Promise((resolve, reject) => {
        configData.getUser()
            .then(response => {
                commit(ADD_USER, response.data);
                resolve(response.data);
            })
            .catch(error => {
                commit(API_ERROR, error["response"]["data"]);
                reject();
            });
    });
};

export const initializeUser = ({commit}) => {
    commit(INITIALIZE_USER);
};

export const changeConfig = ({commit}, configData) => {
    commit(CHANGE_CONFIG, configData);
};