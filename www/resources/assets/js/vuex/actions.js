import configData from '../api/configData'
import store from './store'

export const editServerId = ({commit}, id) => {
    commit('EDIT_SERVER_ID', id)
};

/*export const editRole = ({commit}, data) => {
    commit('EDIT_ROLE', data);
};

export const editChannel = ({commit}, data) => {
    commit('EDIT_CHANNEL', data);
};

export const removeRole = ({commit}, data) => {
    commit('REMOVE_ROLE', data);
};

export const removeChannel = ({commit}, data) => {
    commit('REMOVE_CHANNEL', data);
};*/

export const editData = ({commit}, payload) => {
    commit('EDIT_DATA', {key: payload.key, data: payload.data});
};

export const removeData = ({commit}, payload) => {
    commit('REMOVE_DATA', {key: payload.key, data: payload.data});
};

export const editItemRoles = ({commit}, payload) => {
    commit('EDIT_ITEM_ROLES', payload);
};

export const removeItemRoles = ({commit}, payload) => {
    commit('REMOVE_ITEM_ROLES', payload);
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

export const updateItem = ({commit}, attribute) => {
    commit('UPDATE_ITEM', attribute);
};

export const editItemClass = ({commit}, attribute) => {
    commit('EDIT_ITEM_CLASS', attribute);
};

export const updateRoles = ({commit}, attribute) => {
    commit('EDIT_ROLES', attribute);
};

export const updateChannels = ({commit}, attribute) => {
    commit('EDIT_CHANNELS', attribute);
};

export const updateRolesData = ({commit}, data) => {
    commit('UPDATE_ITEM_MODIFIER', {key: 'roles', data: data});
};

export const updateChannelsData = ({commit}, data) => {
    commit('UPDATE_ITEM_MODIFIER', {key: 'channels', data: data});
};

export const updateState = ({commit}, attribute) => {
    commit('UPDATE_STATE', {key: attribute, data: []});
    return new Promise((resolve, reject) => {
        configData.getValues(store.state.serverId, attribute)
            .then(response => {
                commit('UPDATE_STATE', {key: attribute, data: response['data']});
                resolve();
            })
            .catch(error => {
                commit('API_ERROR', error['response']['data']);
                reject();
            });
    });
};

export const initialState = ({commit}, data) => {
    commit('UPDATE_STATE', {key: null, data: data});
};

export const updateCustomCommands = ({commit}, data) => {
    commit('UPDATE_ITEM_MODIFIER', {key: 'custom_commands', data: data});
};

export const updateCommandCharacter = ({commit}, data) => {
    commit('EDIT_COMMAND_PREFIX', data);
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

export const updateStoreValue = ({commit}, attribute) => {
    commit('UPDATE_STORE_VALUE', attribute)
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