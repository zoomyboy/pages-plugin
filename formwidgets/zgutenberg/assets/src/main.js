import Vue from 'vue';
import App from './App';
import CreateBlock from './CreateBlock';
import Vuex from 'vuex';
import { installer, state } from './blocks.js';
import axios from 'axios';

Vue.use(Vuex);
Vue.use(installer);

const store = new Vuex.Store({
    state: {
        blocks: state,
        renderedBlocks: [],
        sidebar: true,
        selected: null
    },
    getters: {
        asString: (state) => () => {
            return JSON.stringify(state.renderedBlocks);
        }
    },
    mutations: {
        init(state, initialState) {
            state.renderedBlocks = initialState;
        },
        addBlock(state, config) {
            var newLen = state.renderedBlocks.push(config);
            state.selected = newLen - 1;
        },
        select(state, i) {
            state.selected = i;
        },
        sidebar(state, s) {
            state.sidebar = s;
        },
        updateBlock(state, data) {
            if (!state.renderedBlocks[data.id]) { return; }
            state.renderedBlocks[data.id].params = data.params;
            state.renderedBlocks[data.id].content = data.content;
        },
        updateBlockIndex(state, data) {
            console.log(data);
            state.renderedBlocks[data.id].content[data.index] = data.value;
        },
        destroyBlock(state, id) {
            state.renderedBlocks.splice(id, 1);
        }
    }
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
