import modal from './store/modal.js';

export default function({ form, Vuex, blocks }) {
    return new Vuex.Store({
        modules: { modal: modal },
        strict: true,
        state: {
            blocks: blocks,
            renderedBlocks: [],
            sidebar: true,
            handlers: {},
            form: form,
            selected: null
        },
        getters: {
            asString: (state) => () => {
                return JSON.stringify(state.renderedBlocks);
            },
            block: (state) => (k) => {
                return state.renderedBlocks[k];
            },
            formObj(state) {
                return $('#'+state.form);
            },
            selectedRenderedBlock(state) {
                if (state.selected === null) { return []; }
                return state.renderedBlocks[state.selected];
            }
        },
        mutations: {
            init(state, initialState) {
                state.handlers = initialState.handlers;
            },
            updateAvailableBlocks(state, blocks) {
                state.blocks = blocks;
            },
            select(state, i) {
                state.selected = i;
            },
            sidebar(state, s) {
                state.sidebar = s;
            },
            updateBlock(state, data) {
                if (!state.renderedBlocks[data.id]) { return; }
                state.renderedBlocks.splice(data.id, 1, { ...state.renderedBlocks[data.id], 'params': data.params, 'content': data.content });
            },
            updateBlockIndex(state, data) {
                var block = state.renderedBlocks[data.id];
                block.content[data.index] = data.value;
                state.renderedBlocks.splice(data.id, 1, block);
            },
            addBlockIndex(state, data) {
                var block = state.renderedBlocks[data.id];
                block.content.splice(data.index, 0, data.value);
                state.renderedBlocks.splice(data.id, 1, block);
            },
            destroyBlockIndex(state, data) {
                var block = state.renderedBlocks[data.id];
                block.content.splice(data.index, 1);
                state.renderedBlocks.splice(data.id, 1, block);
            },
            destroyBlock(state, id) {
                // Wenn der letzte Block gelöscht wird, selektiere nichts
                if (state.renderedBlocks.length == 1) {
                    state.selected = null;

                // Wenn der letzte Block gelöscht wird, selektiere vorgehenden
                } else if (id == state.renderedBlocks.length - 1) {
                    state.selected--;
                }

                state.renderedBlocks.splice(id, 1);
            },
            addRenderedBlock(state, block) {
                var index = typeof block.after === 'undefined' ? state.renderedBlocks.length : block.after + 1;
                state.renderedBlocks.splice(index, 0, block);
                state.selected = index;
            },
            updateParams(state, { key, value }) {
                var p = state.renderedBlocks[state.selected].params;
                p[key].value = value;

                var newParamsr = { ...state.renderedBlocks[state.selected], params: p };
                state.renderedBlocks.splice(state.selected, 1, newParamsr);
            },
            addSection(state, { after }) {
                if (state.renderedBlocks.length == 0) {
                    state.renderedBlocks = [{ type: 'section', params: state.blocks.section, children: [] }];
                    return;
                }

                state.renderedBlocks.splice(after, 0, { type: 'section', params: state.blocks.section, children: [] });
            }
        },
        actions: {
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
            getInit({ state, commit, getters }, initialState) {
                commit('init', initialState);
                new Promise((resolve) => {
                    getters.formObj.request(state.handlers.blocks, {
                        success(data) {
                            resolve(data);
                        }
                    });
                }).then(data => {
                    commit('updateAvailableBlocks', { ...state.blocks, ...data });
                });
            },
        },
    });
};
