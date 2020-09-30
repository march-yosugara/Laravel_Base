(function () {
  const urls = _urls;

  const form_names = {
    inputs: [
      'note_name'
    ],
    selects: [
      'group_id'
    ],
    radios: [],
  };

  $(window).on('load', () => {
    $('select[name="group_id"]').on('change', function () {
      selectGroup();
    });

    $('#btn_select').on('click', function (e) {
      e.preventDefault();
      selectGroup();
    });

    $('#btn_create').on('click', function (e) {
      e.preventDefault();
      removeErrors();

      var datas = {};
      form_names.inputs.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]').val();
      });
      var group_id = $('select[name="group_id"]').val();
      if (!group_id) {
        alert('Select Group!');
        return;
      }

      axios.post(urls.url_create.replace('group_id', group_id), datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            selectGroup();
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' + err.response.status);
          }
          if (err.response.status === 422) {
            setErrors(err.response.data.errors);
          }
        });
    });
  });

  function selectGroup() {
    var datas = {};
    form_names.selects.forEach(function (name) {
      datas[name] = $('select[name="' + name + '"]').val();
    });

    axios.post(urls.url_select, datas)
      .then(res => {
        $('div.note_card').remove();

        res.data.notes.forEach(function (item) {
          var urlEdit = urls.url_edit;
          var urlRead = urls.url_read;
          urlEdit = urlEdit.replace('group_id', item.group_id).replace('note_id', item.note_id);
          urlRead = urlRead.replace('group_id', item.group_id).replace('note_id', item.note_id);
          const div = [
            '<div class="card card_with_title">',
            '  <div class="card-header">',
            '    <p class="card-title note_name">' + item.note_name + '</p>',
            '  </div>',
            '  <div class="card-body">',
            '    <p class="card-subtitle text-muted note_id">ID : ' + item.note_id + '</p>',
            '    <div class="row">',
            '      <button type=“button” class="btn btn-outline-primary col-5"',
            '        onclick="window.open(\'' + urlEdit + '\',\'_blank\')">Edit</button>',
            '      <button type=“button” class="btn btn-outline-secondary col-5"',
            '        onclick="window.open(\'' + urlRead + '\',\'_blank\')">Read</button>',
            '    </div >',
            '  </div >',
            '</div >',
          ];

          $('#group').after(div.join(''));
        });
      })
      .catch(err => {
        if (err) {
          alert('Error status : ' + err.response.status);
        }
      });
  }

  function setErrors(errors) {
    Object.keys(errors).forEach(name => {
      const html = '<div class="invalid-feedback error-message">' + errors[name][0] + '</div>';
      const target = $('[name="' + name + '"]');
      target.addClass('is-invalid');
      target.after(html);
    });
  }

  function removeErrors() {
    $('div.invalid-feedback').remove();
    $('.is-invalid').removeClass('is-invalid');
  }

})();
