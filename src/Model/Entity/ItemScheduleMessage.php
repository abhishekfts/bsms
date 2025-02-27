<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemScheduleMessage Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $schedule_id
 * @property string|resource $message
 * @property bool $is_read
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $added_date
 * @property \Cake\I18n\FrozenTime $updated_date
 *
 * @property \App\Model\Entity\User $user
 */
class ItemScheduleMessage extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_id' => true,
        'schedule_id' => true,
        'message' => true,
        'is_read' => true,
        'status' => true,
        'added_date' => true,
        'updated_date' => true,
        'user' => true,
    ];
}
