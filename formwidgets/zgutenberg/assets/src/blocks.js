import { kebabCase } from 'lodash';

const requireBlocks = require.context(
    './blocks', false, /^\.\/.*\.js$/
);
const requireBlocksVue = require.context(
    './blocks', false, /^\.\/.*\.vue$/
);

const installer = {
    install(Vue) {
        requireBlocks.keys().forEach((file) => {
            let componentName = file.substr(2).replace('.js', '');

            Vue.component(kebabCase(componentName), requireBlocks(file).component);
        });
        requireBlocksVue.keys().forEach((file) => {
            let componentName = file.substr(2).replace('.vue', '');

            Vue.component(kebabCase(componentName), requireBlocksVue(file).default);
        });
    }
};

var state = {};

requireBlocks.keys().forEach((file) => {
    let componentName = file.substr(2).replace('.js', '');
    state[kebabCase(componentName)] = requireBlocks(file).params;
});
requireBlocksVue.keys().forEach((file) => {
    let componentName = file.substr(2).replace('.vue', '');
    state[kebabCase(componentName)] = requireBlocksVue(file).params;
});

export { installer, state };
