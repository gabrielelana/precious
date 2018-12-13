<?php

namespace Precious;

interface Field
{
    /**
     * Returns the name of the field
     *
     * @returns string
     */
    public function name();

    /**
     * Returns the value of the field picked from an array of values
     *
     * @throws MissingRequiredFieldException
     *
     * @returns mixed
     */
    public function pickIn(array $parameters);
}
