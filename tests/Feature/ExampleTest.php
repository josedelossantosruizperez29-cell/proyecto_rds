<?php

test('la pagina principal responde correctamente', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
