<?php

namespace Potassium\App\Http\Controllers;

use Potassium\App\Traits\AjaxResponder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AjaxResponder;

    /**
     * Incrémente de 1 le champ 'order' de toutes les lignes de la table spécifiée
     *
     * @param  String $table : Table sur laquelle incrémenter le champ 'order'
     * @return Void
     */
    public function incrementOrder($table)
    {
        \DB::table($table)->increment('order');
    }


    /**
     * Répond à une requête HTTP pour réordonner des éléments
     *
     * @param String $table
     *
     * @return void
     */
    public function reorder($table)
    {
        $this->updateOrder($table);

        return $this->respond('Ordre mis à jour');
    }


    /**
     * Réordonne les éléments d'une table
     *
     * @param String $table
     *
     * @return void
     */
    public function updateOrder($table)
    {
        $newOrder = request()->newOrder;

        $query = "UPDATE `{$table}` SET `order` = (CASE `id` ";
        foreach ($newOrder as $place => $id) {
            $query .= " WHEN " . $id . " THEN " . $place;
        }
        $query .= " END) WHERE `id` IN (" . implode(',', $newOrder) . ")";

        \DB::statement($query);
    }

   /**
     * Alterne l'état d'un champ booléen
     *
     * @param   String  $field
     * @param   Entity  $model
     *
     * @return  Void
     */
    public function toggle($field, $model, $onMessage="Visible", $offMessage="Invisible")
    {
        $ok = $model->update([
            $field => request($field)
        ]);

        if ($ok) {
            if (request($field) == 0) {
                return $this->respond($offMessage);
            }

            return $this->respond($onMessage);
        }

        return $this->respondError("Erreur lors de l'opération");
    }
}
