(function ($) {
    var App = function () {
        var o = this;

        $(document).ready(function () {
            o.initialize();
        })
    };

    var p = App.prototype;

    p.initialize = function () {
        this._edit();
        this._delete();
        this._update();
        this._selectAll();
        this._addOption();
        this._deleteMulti();
        this._enableDeleteSelected();
        this._modalEvents('.modal', '.modal form');
        this._removeInput();
        this._addNew();
        this._store();
    };

    /**
     * When Clicked on Edit Button
     * @private
     */
    p._edit = function () {
        var o = this;

        $('.btn-edit').on('click', function () {
            o._getEmployer($(this).data('email'));
        })
    };

    /**
     * When Clicked on Delete Button
     * @private
     */
    p._delete = function () {
        var o = this;
        $('.btn-delete').on('click', function () {
            if (confirm("delete data?")) {
                o._deleteSingle($(this).data('email'))
            }
        })
    };

    /**
     * Check All
     * @private
     */
    p._selectAll = function () {
        $('.select-all').on('change', function () {
            $('#employees tbody input[type=checkbox]').prop('checked', this.checked);

            if (this.checked) {
                $('.btn-delete-all').removeAttr('disabled')
            } else {
                $('.btn-delete-all').attr('disabled', 'disabled')
            }
        })
    };

    /**
     * Enable Delete Selected Button if Found One Checked Item
     * @private
     */
    p._enableDeleteSelected = function () {
        $('.current-employer').on('change', function () {
            var checked = $('#employees tbody input[type=checkbox]:checked').length;

            if (!checked) {
                $('.btn-delete-all').attr('disabled', 'disabled')
            } else {
                $('.btn-delete-all').removeAttr('disabled')
            }
        });
    };

    /**
     * Get Employer by Email From json File
     * @param email
     * @private
     */
    p._getEmployer = function (email) {
        var o = this;

        $.ajax({
            url: "/edit",
            type: "GET",
            dataType: "JSON",
            data: {email: email},
            success: function (data) {
                o._setData(data);
            },

            error: function (jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
                if (errors) {
                    var errorString = "";
                    for (var key in errors) {
                        errorString += errors[key] + " ";
                    }
                }

                alert(errorString);
            }
        });
    };

    /**
     * @param modal
     * @param form
     * @private
     */
    p._modalEvents = function (modal, form) {
        var o = this;

        $(modal).on('hidden.bs.modal', function (e) {
            o._resetFrom(form)
        })
    };

    /**
     * Reset Given Form
     * @param form
     * @private
     */
    p._resetFrom = function (form) {
        $(form)[0].reset();

        $('div.addresses').empty();
        $('div.phones').empty();
    };

    /**
     * Set Data to Modal
     * @param data
     * @private
     */
    p._setData = function (data) {
        var editModal = $('#editModal');

        $.each(data, function (key, value) {
            if (value instanceof Array) {
                for (var i = 0; i < value.length; i++) {
                    $('div.' + key).append(
                        '<div class="input-group mb-2 mr-sm-2 mb-sm-0">' +
                        '<input value="' + value[i] + '" type="text" class="form-control" name="' + key + '[]">' +
                        '<button class="input-group-addon btn btn-danger cursor-pointer remove-button">&times;</button>' +
                        '</div>' +
                        '<br/>'
                    );
                }
            } else {
                $('form.updateForm input[name=' + key + ']').val(value)
            }
        });

        editModal.modal({
            backdrop: false
        })
    };

    p._addNew = function () {
        $('.btn-add-new').on('click', function () {
            $('#addNewModal').modal();
        })
    };

    p._store = function () {
        $('.btn-store').on('click', function () {
            var formData = $('form.addNewForm').serialize();

            $.ajax({
                url: "/store",
                type: "post",
                data: {data: formData},
                success: function (data) {
                    var message = JSON.parse(data).message;
                    $('#addNewModal').modal('hide');
                    alert(message);
                },

                error: function (data) {
                    var message = JSON.parse(data.responseText);

                    alert(message.message)
                }
            });
        })
    };

    /**
     * Update Info
     *
     * @private
     */
    p._update = function () {
        $('.btn-update').on('click', function () {
            var formData = $('form.updateForm').serialize();

            $.ajax({
                url: "/update",
                type: "post",
                data: {email: formData},
                success: function (data) {
                    var message = JSON.parse(data).message;
                    $('#editModal').modal('hide');
                    alert(message);
                },

                error: function (data) {
                    var message = JSON.parse(data.responseText);

                    alert(message.message)
                }
            });
        })
    };

    /**
     * Add Options
     *
     * @private
     */
    p._addOption = function () {
        $('.add-option').on('click', function (e) {
            e.preventDefault();

            var inputName = $(this).parent().prev().data('name');

            $(this).parent().prev().append(
                '<div class="input-group mb-2 mr-sm-2 mb-sm-0">' +
                '<input type="text" class="form-control" name="' + inputName + '[]">' +
                '<button class="input-group-addon btn btn-danger cursor-pointer remove-button">&times;</button>' +
                '</div>' +
                '<br/>'
            );
        })
    };

    /**
     * Remove Inputs
     *
     * @private
     */
    p._removeInput = function () {
        $(document).on('click', '.remove-button', function (e) {
            e.preventDefault();

            $(this).parent().next().remove();

            $(this).parent().remove();
        })
    };

    /**
     * Delete Single Value From json File
     * @param email
     * @private
     */
    p._deleteSingle = function (email) {
        $.ajax({
            url: "/delete",
            type: "GET",
            dataType: "JSON",
            data: {email: email},
            success: function (data) {
                $('#employees tbody th:contains(' + data.email + ')').parent().remove();
            },

            error: function (jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;

                if (errors) {
                    var errorString = "";
                    for (var key in errors) {
                        errorString += errors[key] + " ";
                    }
                }

                alert(errorString);
            }
        });
    };

    /**
     * Delete Selected Items
     *
     * @private
     */
    p._deleteMulti = function () {
        $(".btn-delete-all").on('click', function () {
            var emails = [];

            for (var i = 0; i < $('#employees tbody input[type=checkbox]:checked').length; i++) {
                emails.push($('#employees tbody input[type=checkbox]:checked').eq(i).data('email'));
            }

            $.ajax({
                url: "/multi-delete",
                type: "post",
                data: {emails: emails},
                success: function (data) {
                    var emailsArray = JSON.parse(data);

                    var datLength = emailsArray.length;

                    for (var i = 0; i < datLength; i++) {
                        $('#employees tbody th:contains(' + emailsArray[i] + ')').parent().remove();
                    }
                },
                error: function (jqXhr, json, errorThrown) {
                    var errors = jqXhr.responseJSON;
                    if (errors) {
                        var errorString = "";
                        for (var key in errors) {
                            errorString += errors[key] + " ";
                        }
                    }

                    alert(errorString);
                }
            });

        })
    };

    window.app = new App;
}(jQuery));