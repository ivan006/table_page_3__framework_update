      <br>
      <details>
        <summary>Data</summary>
        <pre><?php
          if (isset($data)) {
            echo json_encode($data, JSON_PRETTY_PRINT);
          }
          ?>
        </pre>
      </details>
      <br>
    </div>
  </body>
</html>
