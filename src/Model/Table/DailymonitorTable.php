<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Dailymonitor Model
 *
 * @property \App\Model\Table\ProductionLinesTable&\Cake\ORM\Association\BelongsTo $ProductionLines
 * @property \App\Model\Table\MaterialsTable&\Cake\ORM\Association\BelongsTo $Materials
 *
 * @method \App\Model\Entity\Dailymonitor newEmptyEntity()
 * @method \App\Model\Entity\Dailymonitor newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Dailymonitor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Dailymonitor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Dailymonitor findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Dailymonitor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Dailymonitor[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Dailymonitor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dailymonitor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dailymonitor[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Dailymonitor[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Dailymonitor[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Dailymonitor[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DailymonitorTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dailymonitor');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductionLines', [
            'foreignKey' => 'production_line_id',
        ]);
        $this->belongsTo('Materials', [
            'foreignKey' => 'material_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('sap_vendor_code')
            ->maxLength('sap_vendor_code', 10)
            ->requirePresence('sap_vendor_code', 'create')
            ->notEmptyString('sap_vendor_code');

        $validator
            ->integer('production_line_id')
            ->allowEmptyString('production_line_id');

        $validator
            ->integer('material_id')
            ->allowEmptyString('material_id');

        $validator
            ->date('plan_date')
            ->allowEmptyDate('plan_date');

        $validator
            ->decimal('target_production')
            ->requirePresence('target_production', 'create')
            ->notEmptyString('target_production');

        $validator
            ->decimal('confirm_production')
            ->allowEmptyString('confirm_production');

        $validator
            ->allowEmptyString('status');

        $validator
            ->dateTime('added_date')
            ->allowEmptyDateTime('added_date');

        $validator
            ->dateTime('updated_date')
            ->allowEmptyDateTime('updated_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('production_line_id', 'ProductionLines'), ['errorField' => 'production_line_id']);
        $rules->add($rules->existsIn('material_id', 'Materials'), ['errorField' => 'material_id']);

        return $rules;
    }
}
