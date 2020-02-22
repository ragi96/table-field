# Kirby table-field
A Table Field for Kirby V3

![Table Field Preview](https://raw.githubusercontent.com/ragi96/table-field/preview.png "table field preview")

## Usage

As any Kirby field:
```yaml
  fields:
    table:
      label: table
      type: table
      options:
        maxColumns: 42
        minColumns: 5
```

Options are not required. Defaults are:
```yaml
        maxColumns: 10
        minColumns: 1
```

Content is structured like an yaml array


In your template you can simply use the function ```toTable()```

Example:
```php
<?php $table = $data->table()->toTable(); ?>
<table>
  <?php foreach ($table as $tableRow): ?>
    <tr>
      <?php foreach ($tableRow as $tableCell): ?>
        <td><?= $tableCell; ?></td>
      <?php endforeach; ?>
    </tr>
  <?php endforeach; ?>
</table>
 ```

## Installation
To install the plugin, please put it in the `site/plugins` directory.  
The field folder must be named `table-field`.

### Download
Link to latest version https://github.com/ragi96/table-field/releases/latest

### With Git
```git clone https://github.com/ragi96/table-field/releases.git table-field```
