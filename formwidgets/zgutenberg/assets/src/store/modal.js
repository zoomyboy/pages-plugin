export default {

    namespaced: true,

    state: {
        popups: []
    },

    actions: {
        open({ commit }, data) {
            return new Promise((resolve, reject) => {
                commit('add', {
                    params: {},
                    ...data,
                    resolve: resolve,
                    reject: reject
                });
            });
        },
        close({ commit }, index) {
            commit('delete', index);
        }
    },
    getters: {
        all({ popups }) {
            return popups;
        },
        any({ popups }) {
            return popups.length > 0;
        }
    },
    mutations: {
        add({ popups }, payload) {
            popups.push(payload);
        },
        delete({ popups }, index) {
            popups.splice(index, 1);
        }
    }
};

