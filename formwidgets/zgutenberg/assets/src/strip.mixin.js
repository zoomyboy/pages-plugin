import striptags from 'striptags';

export default {
    methods: {
        s(s) {
            return striptags(s);
        }
    }
};
