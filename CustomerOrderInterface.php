<?php
namespace  Order\Details\Api;


interface CustomerOrderInterface
{
    /**
     * Returns orders data to user
     *
     * @api
     * @param  string $id customer id.
     * @return return order array collection.
     */
    public function getList($id);
}