export default function({ form, Vuex }) {
    return new Vuex.Store({
        strict: true,
        state: {
            renderedBlocks: [],
            sidebar: true,
            handlers: {},
            form: form,
            selected: null
        },
        getters: {
            formObj(state) {
                return $('#'+state.form);
            },
        },
        mutations: {
            init(state, initialState) {
                state.handlers = initialState.handlers;
            }
        },
        actions: {

            async request({ getters, state }, { handler, params }) {
                return new Promise((resolve) => {
                    getters.formObj.request(state.handlers[handler], {
                        data: params,
                        success(data) {
                            resolve(data);
                        }
                    });
                });
            },

            loadParams({ getters, commit, state }, component) {
                return new Promise((resolve) => {
                    getters.formObj.request(state.handlers.params, {
                        data: { component: component },
                        success: function(data) {
                            resolve(data);
                        }
                    });
                });
            },
            async addBlock({ state, dispatch, commit }, config) {
                if (typeof config.loadParams !== 'undefined') {
                    config.params = await dispatch('loadParams', config.loadParams);
                }

                commit('addRenderedBlock', config);
            },
            getInit({ dispatch, state, commit, getters }, initialState) {
                commit('init', initialState);
            },
        },
    });
};
