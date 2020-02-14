export default function({ form, Vuex, blocks }) {
    return new Vuex.Store({
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
            sidebarParams(state) {
                if (!state.selected) { return []; }
                return state.renderedBlocks[state.selected].params;
            },
            selectedBlockType(state) {
                if (!state.selected) { return []; }

                return state.blocks[state.renderedBlocks[state.selected].component];
            }
        },
        mutations: {
            init(state, initialState) {
                state.renderedBlocks = initialState.data;
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
                state.renderedBlocks.splice(id, 1);
            },
            addRednderedBlock(state, block) {
                var newLen = state.renderedBlocks.push(block);
                state.selected = newLen - 1;
            },
            updateParams(state, { key, value }) {
                var p = state.renderedBlocks[state.selected].params;
                p[key].value = value;

                var newParamsr = { ...state.renderedBlocks[state.selected], params: p };
                state.renderedBlocks.splice(state.selected, 1, newParamsr);
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

                commit('addRednderedBlock', config);
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
