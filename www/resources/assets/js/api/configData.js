import axios from 'axios'

const instance = axios.create({
    baseURL: '/api/',
    withCredentials: true
});

export default {
    getRoles (serverId) {
        return instance.get('/roles/'+serverId);
    },
    getChannels (serverId) {
        return instance.get('/channels/'+serverId);
    },
    getValues (serverId, attribute) {
        return instance.get('/data/'+serverId+'/'+attribute);
    },
    getBotwinderCommands () {
        return instance.get('/botwinderCommands');
    }
}