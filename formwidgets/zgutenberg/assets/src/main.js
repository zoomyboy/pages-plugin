import Vue from 'vue';
import App from './App';
import CreateBlock from './CreateBlock';
import Vuex from 'vuex';
import { installer, state } from './blocks.js';
import axios from 'axios';

Vue.use(Vuex);
Vue.use(installer);

const store = new Vuex.Store({
    strict: true,
    state: {
        blocks: state,
        renderedBlocks: [],
        sidebar: true,
        handlers: {},
        form: null,
        selected: null
    },
    getters: {
        asString: (state) => () => {
            return JSON.stringify(state.renderedBlocks);
        },
        block: (state) => (k) => {
            return state.renderedBlocks[k];
        }
    },
    mutations: {
        init(state, initialState) {
            state.renderedBlocks = initialState.data;
            state.handlers = initialState.handlers;
            state.form = initialState.form;
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
        }
    },
    actions: {
        loadParams({ commit, state }, component) {
            return new Promise((resolve) => {
                $('#'+state.form).request(state.handlers.params, {
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
    },
});

jQuery(document).ready(function() {
    document.querySelectorAll('[data-zgutenberg]').forEach(function(el) {
        Vue.component('create-block', CreateBlock);

        var app = new Vue({
            el: el,
            store,
            components: { App }
        });
    });
});
