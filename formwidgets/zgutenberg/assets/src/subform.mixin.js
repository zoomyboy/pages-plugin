export default {
    methods: {
        openForm(subform, heading, data) {
            return new Promise(resolve => {
                $('#subform-popup').find('.modal-body').html('');
                $('#subform-popup').request('onEdit', {
                    url: '/backend/rainlab/pages/forms',
                    data: { subform: subform, data: data},
                    success: function(data, status, xhr) {
                        $('#subform-popup').modal();
                        $('#subform-popup').modal('show');
                        this.success(data, status, xhr);
                        $('#subform-popup').find('.modal-body').html(data.content);
                        $('#subform-popup').find('.modal-title').html(heading);

                        $('#subform-popup').find('[data-confirm]').one('click', function() {
                            $('#subform-popup').on('hidden.bs.modal', () => {
                                $('#subform-popup').find('form').request('onSave', {
                                    url: '/backend/rainlab/pages/forms',
                                    data: { subform: subform },
                                    success: function(data, status, xhr) {
                                        this.success(data, status, xhr);
                                        resolve(data);
                                    }
                                });
                            });
                            $('#subform-popup').modal('hide');
                        });
                    }
                });
            });
        }
    },

    mounted() {
        if ($('#subform-popup').length > 0) {
            return;
        }

        var content = `<div class="control-popup modal fade" id="subform-popup">
            <div class="modal-dialog">
                <form>
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" data-confirm>Änderungen übernehmen</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>`;

        $('body').append(content);
    }
};
