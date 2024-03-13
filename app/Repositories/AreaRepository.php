<?php
namespace App\Repositories;

use App\Models\Area;

class AreaRepository extends BaseRepository
{
    protected $area;
    /**
     * Create a new repository instance.
     * Created at: 12/03/2024
     * Created by: Hieu
     *
     * @param  \App\Models\Area  $area
     * @return void
     */
    public function __construct(Area $area)
    {
        $this->area = $area;
        $this->setModel();
    }

    /**
     * Setting model want to interact
     * Created at: 12/03/2023
     * Created by: Hieu
     *
     * @access public
     * @return string
     */
    public function getModel()
    {
        return Area::class;
    }
}
