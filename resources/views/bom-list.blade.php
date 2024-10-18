<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bom List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

</head>
<body>
    <div id="treeview"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#treeview').jstree({
                "core": {
                    "themes": {
                        "responsive": false
                    },
                    'data': {
                        'url': function(node) {
                            //  return 'https://preview.keenthemes.com/api/jstree/ajax_data.php'; // Demo API endpoint -- Replace this URL with your set endpoint
                            return '{{ route("bom-list.list") }}';
                        },
                        'data': function(node) {
                            return {
                                'parent': node.id,
                            };
                        }
                    }
                },
            })
        })
    </script>
</body>
</html>