import configData from '../api/configData'
import store from './store'

export const editServerId = ({commit}, id) => {
    commit('EDIT_SERVER_ID', id)
}

export const editRoles = ({commit}, roles) => {
    commit('EDIT_ROLES', roles)
}

export const editChannels = ({commit}, channels) => {
    commit('EDIT_CHANNELS', channels)
}

export const editData = ({commit}, payload) => {
    commit('EDIT_DATA', {key: payload.key, data: payload.data});
}

export const removeData = ({commit}, payload) => {
    commit('REMOVE_DATA', {key: payload.key, data: payload.data});
}

export const editCustomCommandsRoles = ({commit}, payload) => {
    commit('EDIT_CUSTOM_COMMANDS_ROLES', {key: payload.key, data: payload.data});
}

export const removeCustomCommandsRoles = ({commit}, payload) => {
    commit('REMOVE_CUSTOM_COMMANDS_ROLES', {key: payload.key, data: payload.data});
}

export const updateActiveCustomCommand = ({commit}, attribute) => {
    commit('UPDATE_ACTIVE_CUSTOM_COMMAND', attribute);
}

export const updateActiveCustomCommandData = ({commit}, attribute) => {
    commit('UPDATE_ACTIVE_CUSTOM_COMMAND_DATA', attribute);
}

export const addCustomCommand = ({commit}, attribute) => {
    commit('ADD_CUSTOM_COMMAND', attribute);
}

export const removeCustomCommand = ({commit}, attribute) => {
    commit('REMOVE_CUSTOM_COMMAND', attribute);
}

export const updateRoles = ({commit}) => {
    configData.getRoles(store.state.serverId)
        .then(response => {
            commit('EDIT_ROLES', response['data']);
            //console.log(store.state.roles);
        })
        .catch(error => {
            console.log(error);
        });

}

export const updateChannels = ({commit}) => {
    configData.getChannels(store.state.serverId)
        .then(response => {
            commit('EDIT_CHANNELS', response['data']);
            //console.log(store.state.channels);
        })
        .catch(error => {
            console.log(error);
        });
}

export const updateState = ({commit}, attribute) => {
    commit('UPDATE_STATE', {key: attribute, data: []});
    return new Promise((resolve, reject) => {
        configData.getValues(store.state.serverId, attribute)
            .then(response => {
                commit('UPDATE_STATE', {key: attribute, data: response['data'] || []});
                resolve()
            })
            .catch(error => {
                console.log(error);
                reject();
            });
    });
}

export const updateCustomCommands = ({commit}, attribute) => {
    return new Promise((resolve, reject) => {
        configData.getValues(store.state.serverId, attribute)
            .then(response => {
                commit('UPDATE_CUSTOM_COMMANDS', response['data']);
                resolve()
            })
            .catch(error => {
                console.log(error);
                reject()
            });
    })
}

export const updateCommandCharacter = ({commit}, attribute) => {
    commit('UPDATE_COMMAND_CHARACTER', attribute)
}

export const updateBotwinderCommands = ({commit}) => {
    configData.getBotwinderCommands()
        .then(response => {
            commit('UPDATE_BOTWINDER_COMMANDS', response['data']);
        })
        .catch(error => {
            console.log(error);
        });
}