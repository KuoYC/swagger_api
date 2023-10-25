<!DOCTYPE html>
<html>
<head>
  <title>API Documentation</title>
  <link rel="stylesheet" type="text/css" href="dist/swagger-ui.css">
</head>
<body>
<div id="swagger-ui"></div>

<script src="dist/swagger-ui-bundle.js"></script>
<script src="dist/swagger-ui-standalone-preset.js"></script>

<script>
  window.onload = function() {
    const ui = SwaggerUIBundle({
      url: "swagger.json", // 将swagger.json替换为你的Swagger（OpenAPI）规范文件的URL
      dom_id: '#swagger-ui',
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      layout: "BaseLayout"
    });
  };
</script>
</body>
</html>
