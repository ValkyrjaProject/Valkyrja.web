import configData from '../api/configData'
import store from './store'

export const editServerId = ({commit}, id) => {
    commit('EDIT_SERVER_ID', id)
};

export const editRoles = ({commit}, roles) => {
    commit('EDIT_ROLES', roles)
};

export const editChannels = ({commit}, channels) => {
    commit('EDIT_CHANNELS', channels)
};

export const editData = ({commit}, payload) => {
    commit('EDIT_DATA', {key: payload.key, data: payload.data});
};

export const removeData = ({commit}, payload) => {
    commit('REMOVE_DATA', {key: payload.key, data: payload.data});
};

export const editCustomCommandsRoles = ({commit}, payload) => {
    commit('EDIT_CUSTOM_COMMANDS_ROLES', {key: payload.key, data: payload.data});
};

export const removeCustomCommandsRoles = ({commit}, payload) => {
    commit('REMOVE_CUSTOM_COMMANDS_ROLES', {key: payload.key, data: payload.data});
};

export const updateActiveItem = ({commit}, attribute) => {
    commit('UPDATE_ACTIVE_ITEM', attribute);
};

export const updateActiveItemData = ({commit}, attribute) => {
    commit('UPDATE_ACTIVE_ITEM_DATA', attribute);
};

export const addItem = ({commit}, attribute) => {
    commit('ADD_ITEM', attribute);
};

export const removeItem = ({commit}, attribute) => {
    commit('REMOVE_ITEM', attribute);
};

export const editItemClass = ({commit}, attribute) => {
    commit('EDIT_ITEM_CLASS', attribute);
};

export const updateRoles = ({commit}) => {
    configData.getRoles(store.state.serverId)
        .then(response => {
            commit('EDIT_ROLES', response['data']);
        })
        .catch(error => {
            commit('API_ERROR', error['response']['data']);
        });

};

export const updateChannels = ({commit}) => {
    configData.getChannels(store.state.serverId)
        .then(response => {
            commit('EDIT_CHANNELS', response['data']);
        })
        .catch(error => {
            commit('API_ERROR', error['response']['data']);
        });
};

export const updateState = ({commit}, attribute) => {
    commit('UPDATE_STATE', {key: attribute, data: []});
    return new Promise((resolve, reject) => {
        configData.getValues(store.state.serverId, attribute)
            .then(response => {
                commit('UPDATE_STATE', {key: attribute, data: response['data'] || []});
                resolve();
            })
            .catch(error => {
                commit('API_ERROR', error['response']['data']);
                reject();
            });
    });
};

export const updateItemModifier = ({commit}, attribute) => {
    commit('UPDATE_ITEM_MODIFIER', {key: attribute, data: []});
    return new Promise((resolve, reject) => {
        configData.getValues(store.state.serverId, attribute)
            .then(response => {
                commit('UPDATE_ITEM_MODIFIER', {key: attribute, data: response['data']});
                resolve()
            })
            .catch(error => {
                commit('API_ERROR', error['response']['data']);
                reject()
            });
    })
};

export const updateCommandCharacter = ({commit}, attribute) => {
    commit('UPDATE_COMMAND_CHARACTER', attribute)
};

export const updateBotwinderCommands = ({commit}) => {
    configData.getBotwinderCommands()
        .then(response => {
            commit('UPDATE_BOTWINDER_COMMANDS', response['data']);
        })
        .catch(error => {
            commit('API_ERROR', error['response']['data']);
        });
};

export const clearAPIError = ({commit}) => {
    commit('CLEAR_API_ERROR');
};