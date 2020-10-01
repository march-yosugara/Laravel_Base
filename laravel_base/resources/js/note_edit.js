(function () {
  const urls = _urls;

  const form_names = {
    inputs: [
      'note_item_title',
      'str1',
      'int_val1',
      'unit1',
      'str2',
      'int_val2',
      'unit2',
    ],
    selects: [],
    radios: [],
    textareas: [
      'memo',
    ],
  };

  $(window).on('load', () => {
    $('#btn_update').on('click', function (e) {
      e.preventDefault();
      var datas = {};
      datas['note_name'] = $('input[name="note_name"]').val();
      datas['group_id'] = $('input[name="group_id"]').val();
      datas['note_id'] = $('input[name="note_id"]').val();

      var items = {};
      $('.note_item').each(function (index, item) {
        var item_columns = {};
        item_columns['note_item_id'] = item.id;
        form_names.inputs.forEach(function (name) {
          item_columns[name] = $(item).find('input[name="' + name + '"]').val();
        });
        form_names.textareas.forEach(function (name) {
          item_columns[name] = $(item).find('textarea[name="' + name + '"]').val();
        });
        items[index] = item_columns;
      });
      datas['note_items'] = items;

      axios.post(urls.url_update, datas)
        .then(res => {
          const message = res.data.message_note + '\n' + res.data.message_items;
          alert(message);
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' + err.response.status);
          }
        });
    });

    $('#btn_add').on('click', function (e) {
      e.preventDefault();
      $('.btn_remove').off('click');

      const item = {
        'note_item_id': 0,
        'note_item_title': '',
        'str1': '',
        'int_val1': '',
        'unit1': '',
        'str2': '',
        'int_val2': '',
        'unit2': '',
        'memo': '',
      };

      createItem(item);
      setEventRemoveItem();
    });

    $('#btn_delete').on('click', function (e) {
      e.preventDefault();
      var datas = {};
      datas['group_id'] = $('input[name="group_id"]').val();
      datas['note_id'] = $('input[name="note_id"]').val();

      axios.post(urls.url_delete, datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            window.close();
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' + err.response.status);
          }
        });
    });

    setEventRemoveItem();
  });

  function createItem(item) {
    const div = [
      '<div class="card card_with_title note_item" id="' + item.note_item_id + '">',
      '  <div class="card-header note_item_title row">',
      '    <input name="note_item_title" type="text" class="form-control col-10"',
      '      maxlength="100" placeholder="Note item title" value="' + item.note_item_title + '">',
      '    <button type="button" class="btn btn-outline-danger rounded-circle p-0 btn_remove col-2">×</button>',
      '  </div>',
      '  <div class="card-body">',
      '    <div class="row item1">',
      '      <input name="str1" type="text" class="form-control col-5"',
      '        maxlength="100" placeholder="string1" value="' + item.str1 + '">',
      '      <input name="int_val1" type="number" class="form-control col-5 int"',
      '        placeholder="integer1" value="' + item.int_val1 + '">',
      '      <input name="unit1" type="text" class="form-control col-2"',
      '        maxlength="10" placeholder="unit1" value="' + item.unit1 + '">',
      '    </div>',
      '    <div class="row item2">',
      '      <input name="str2" type="text" class="form-control col-5"',
      '        maxlength="100" placeholder="string2" value="' + item.str2 + '">',
      '      <input name="int_val2" type="number" class="form-control col-5 int"',
      '        placeholder="integer2" value="' + item.int_val2 + '">',
      '      <input name="unit2" type="text" class="form-control col-2"',
      '        maxlength="10" placeholder="unit2" value="' + item.unit2 + '">',
      '    </div>',
      '    <div class="row item_memo">',
      '      <textarea name="memo" type="text" class="form-control col-12" rows="2"',
      '        placeholder="memo">' + item.memo + '</textarea>',
      '    </div>',
      '  </div>',
      '</div>',
    ];

    $('#add_point').before(div.join(''));
  }

  function setEventRemoveItem() {
    $('.btn_remove').on('click', function (e) {
      e.preventDefault();

      $(this).parent().parent().remove();
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
