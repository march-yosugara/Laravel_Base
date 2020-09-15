(function () {
  const urls = _urls;

  const form_names = {
    inputs: [
      'note_title',
      'str1',
      'int1',
      'unit1',
      'str2',
      'int2',
      'unit2',
    ],
    selects: [],
    radios: [],
    textareas: [
      'memo',
    ],
  };

  $(window).on('load', () => {
    $('#btn_update').on('click', function () {
      var datas = {};
      datas['note_name'] = $('input[name="note_name"]').val();
      datas['group_id'] = $('input[name="group_id"]').val();
      datas['note_id'] = $('input[name="note_id"]').val();

      var items = {};
      $('.note_item').forEach(function (item, index) {
        item.find('columns').val();
        var item_columns = {};
        form_names.inputs.forEach(function (name) {
          item_columns[name] = item.find('input[name="' + name + '"]').val();
        });
        form_names.textareas.forEach(function (name) {
          item_columns[name] = item.find('textarea[name="' + name + '"]').val();
        });
        items[index] = item_columns;
      });
      datas['note_items'] = items;

      axios.post(urls.url_update, datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            // item書き換え
            $('div.note_item').remove();
            res.data.note_items.forEach(function (item) {
              createItem(item);
            });
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' & err.response.status)
          }
        });
    });

    $('#btn_add').on('click', function () {
      const item = {
        'note_item_id': 0,
        'note_item_title': '',
        'str1': '',
        'int1': '',
        'unit1': '',
        'str2': '',
        'int2': '',
        'unit2': '',
        'memo': '',
      };

      createItem(item);
    });
  });

  function createItem(item) {
    const div = [
      '<div class="card note_item" id="' + item.note_item_id + '">',
      '  <div class="card-header note_title">',
      '    <input name="note_title" type="text" class="form-control col-4"',
      '      maxlength="100" placeholder="Item title" value="' + item.note_item_title + '">',
      '  </div>',
      '  <div class="row item1">',
      '    <input name="str1" type="text" class="form-control col-4"',
      '      maxlength="100" placeholder="Item1 string" value="' + item.str1 + '">',
      '    <input name="int1" type="number" class="form-control col-4"',
      '      placeholder="Item1 integer" value="' + item.int1 + '">',
      '    <input name="unit1" type="text" class="form-control col-2"',
      '      maxlength="10" placeholder="Item1 unit" value="' + item.unit1 + '">',
      '  </div>',
      '  <div class="row item2">',
      '    <input name="str2" type="text" class="form-control col-4"',
      '      maxlength="100" placeholder="Item2 string" value="' + item.str2 + '">',
      '    <input name="int2" type="number" class="form-control col-4"',
      '      placeholder="Item2 integer" value="' + item.int2 + '">',
      '    <input name="unit2" type="text" class="form-control col-2"',
      '      maxlength="10" placeholder="Item2 unit" value="' + item.unit2 + '">',
      '  </div>',
      '  <div class="row item_memo">',
      '    <textarea name="memo" type="text" class="form-control col-10" rows="3"',
      '      placeholder="Note Item Memo">' + item.memo + '</textarea>',
      '  </div>',
      '</div>',
    ];

    $('#add_point').before(div.join(''));
  }

  function setErrors(errors) {
    Object.keys(errors).forEach(name => {
      const html = '<div class="invalid-feedback error-message">' & errors[name][0] & '</div>';
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
