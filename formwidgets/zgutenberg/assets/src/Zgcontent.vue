<template>
    <div class="zg-content zg-px-6">
        <div class="zg-relative zg-flex"
            :class="{'zg-mt-6': index !== 0}"
            v-for="(section, index) in value"
            v-if="value.length !== 0" 
        >
            <div class="zg-mr-6 zg-bg-gray-400 zg-shadow" v-show="section.sidebar.meta.position == 'left'">
                <div class="zg-bg-sidebar flex-grow zg-flex zg-rounded zg-p-3 zg-items-center">
                    <input type="text" v-model="section.sidebar.meta.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-sidebar zg-outline-none zg-text-center zg-text-white zg-w-full">
                    <a href="#" @click.prevent="editSidebar(section, index)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-cog"></span></a>
                    <a href="#" @click.prevent="toggleSidebar(section, index, null)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-trash"></span></a>
                </div>

                <div class="zg-p-4">
                    <v-column v-model="section.sidebar.modules" @create="createSidebarModule(index, $event)" @edit="editModule(index, $event)" @delete="deleteModule(index, $event)"></v-column>
                </div>
            </div>

            <div class="zg-flex-grow zg-bg-gray-400 zg-shadow">

                <div class="zg-bg-section zg-flex zg-rounded zg-p-3 zg-items-center">
                    <a href="#" @click.prevent="toggleSidebar(section, index, 'left')" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-columns"></span></a>
                    <input type="text" v-model="section.meta.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-section zg-outline-none zg-text-center zg-text-white zg-w-full">
                    <a href="#" @click.prevent="edit(section, index)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-cog"></span></a>
                    <a href="#" @click.prevent="remove(index)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-trash"></span></a>
                    <a href="#" @click.prevent="toggleSidebar(section, index, 'right')" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-columns"></span></a>
                </div>

                <v-section v-model="section.rows" :key="index"></v-section>

                <div class="zg-flex zg-justify-center zg-absolute zg-bottom-0 zg--mt-3 zg-w-full zg-left-0 zg-top-full">
                    <a href="#" @click.prevent="addSection(index)" class="zg-btn zg-btn-sm zg-bg-section">
                        <span class="icon-plus"></span>
                    </a>
                </div>

            </div>

            <div class="zg-mr-6 zg-bg-gray-400 zg-shadow" v-show="section.sidebar.meta.position == 'right'">
                <div class="zg-bg-sidebar flex-grow zg-flex zg-rounded zg-p-3 zg-items-center">
                    <input type="text" v-model="section.sidebar.meta.title" class="zg-flex-grow zg-border-0 zg-leading-none zg-bg-sidebar zg-outline-none zg-text-center zg-text-white zg-w-full">
                    <a href="#" @click.prevent="editSidebar(section, index)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-cog"></span></a>
                    <a href="#" @click.prevent="toggleSidebar(section, index, null)" class="hover:zg-no-underline zg-mr-2"><span class="zg-text-white icon-trash"></span></a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VSection from './components/VSection';
import VColumn from './components/VColumn';
import subform from './subform.mixin.js';

export default {
    mixins: [ subform ],

    props: {
        value: {}
    },

    components: { VSection, VColumn },

    methods: {
        createSidebarModule(sectionIndex, moduleIndex) {
            var modules = this.value[sectionIndex].modules;

            this.openForm('module_sidebar', 'Modul einfügen', {}).then(formData => {
                var formData = { ...formData.data };
                this.openForm(formData.is, formData.meta.title, formData.meta).then(moduleData => {
                    formData.meta = moduleData;

                    modules.splice(moduleIndex+1, 0, formData);
                }).catch(err => {
                    console.log(err);
                });
            }).catch(err => {
                console.log(err);
            });
        },
        remove(index) {
            var content = this.value;
            content.splice(index, 1);
            this.$emit('input', content);
        },
        edit(section, index) {
            this.openForm('section_edit', 'Sektion bearbeiten', section.meta).then(data => {
                section.meta = { ...section.meta, ...data };
            });
        },
        editSidebar(section, index) {
            this.openForm('sidebar', 'Seitenleiste bearbeiten', section.sidebar.meta).then(data => {
                section.sidebar.meta = data;
            });
        },
        toggleSidebar(section, index, position) {
            if (section.sidebar.meta.position === false) {
                this.openForm('sidebar', 'Seitenleiste erstellen', { position: position, title: 'Seitenleiste' }).then(data => {
                    section.sidebar.meta = data;
                });
            } else {
                section.sidebar.meta.position = false;
            }
        },
        addSection(index) {
            this.openForm('section', 'Sektion einfügen', {
                section: { title: 'Sektion' },
                row: { title: 'Zeile' },
            }).then(formData => {
                var columns = formData.layout.split(',').map(column => {
                    return {
                        width: column,
                        modules: []
                    };
                });

                var newSection = { 
                    sidebar: {
                        meta: { position: false },
                        modules: [],
                    },
                    meta: formData.section,
                    rows: [ {
                        meta: formData.row,
                        columns: columns
                    } ]
                };

                if (typeof index == "undefined") {
                    this.$emit('input', [ newSection ]);
                    return;
                }

                var content = this.value;
                content.splice(index+1, 0, newSection);
                this.$emit('input', content);
            });
        }
    }
};
</script>
