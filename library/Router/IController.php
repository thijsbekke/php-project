<?php

namespace Router;

interface IController {

    public function index();
    public function create();
    public function edit($id);
    public function show($id);
    public function delete($id);

}
