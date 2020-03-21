import Vue from 'vue';
import App from './App';
import Vuex from 'vuex';
import { installer, blocks } from './blocks.js';
import axios from 'axios';
import store from './store.js';
import Editable from './Editable.js';

Vue.use(Vuex);
Vue.use(installer);

Vue.component('editable', Editable);

+function ($) { "use strict";
    var Base = $.oc.foundation.base,
        BaseProto = Base.prototype

    var Zgutenberg = function (element, options) {
        this.$el = $(element)
        this.$form = $(element).closest('form');
        this.options = options || {}

        $.oc.foundation.controlUtils.markDisposable(element)
        Base.call(this)
        this.init()
    }

    Zgutenberg.prototype = Object.create(BaseProto)
    Zgutenberg.prototype.constructor = Zgutenberg

    Zgutenberg.prototype.init = function() {
        var formId = this.setFormId();

        this.$app = new Vue({
            el: this.$el.children('div').get(0),
            store: store({
                form: formId,
                blocks: blocks,
                Vuex: Vuex
            }),
            components: { App }
        });
    }

    Zgutenberg.prototype.setFormId = function() {
        this.formId = Math.random().toString(36).substring(7) + Math.random().toString(36).substring(7);
        this.$form.attr('id', this.formId);

        return this.formId;
    }

    Zgutenberg.DEFAULTS = {
        someParam: null
    }

    // PLUGIN DEFINITION
    // ============================

    var old = $.fn.zgutenberg

    $.fn.zgutenberg = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), items, result

        items = this.each(function () {
            var $this   = $(this)
            var data    = $this.data('oc.zgutenberg')
            var options = $.extend({}, Zgutenberg.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.zgutenberg', (data = new Zgutenberg(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : items
    }

    $.fn.zgutenberg.Constructor = Zgutenberg

    $.fn.zgutenberg.noConflict = function () {
        $.fn.zgutenberg = old
        return this
    }

    $(document).render(function (){
        $('[data-zgutenberg]').zgutenberg()
    })

}(window.jQuery);
