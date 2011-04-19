<?php

namespace TrustedForms\CodeGenerator;

interface CodeWriter
{
    public function newReporter(); // reporter must have addFlag($flag,$value);
}
