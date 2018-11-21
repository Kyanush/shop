import Vue from 'vue'

const state = {
    user: []
}

const getters = {
    RoleName: (state) => {
        return state.user.id ? state.user.role.name: null;
    },
    UserId: (state) => {
        return parseInt(state.user.id);
    },
    RoleDesc: (state) => {
        return state.user.role.description;
    },
    UserName: (state) => {
        return state.user.name;
    }
}

const actions = {
    SetUser ({ commit, state }, user) {
       commit('SetUser', user);
    }
}

const mutations = {

    SetUser(state, user){
        state.user = user;
    }

}

export default {
    state,
    getters,
    actions,
    mutations
};