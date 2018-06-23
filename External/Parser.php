public function upload(Request $request)
{
  if($request->hasFile('logfile') && $request->file('logfile')->isValid() && $request->file('logfile')->guessExtension() == 'txt')
    {
      $log_id = DB::table('logs')->orderBy('id', 'desc')->value('id');
      $content = $request->input('content');
      $realm = $request->input('realm');
      $guild = $request->input('guild');
      $user_id = Auth::id();
      if($log_id >= 0)
        $log_id++;
      else
        $log_id = 0;
      $i      = 0;
      $keysNormal = ['sourceGUID','sourceName','sourceFlags','destGUID','destName','destFlags'];
      $keysByType =
      [
      'SWING_DAMAGE'                  => ['amount', 'overkill', 'school', 'resisted', 'blocked', 'absorbed', 'critical', 'glancing', 'crushing'],
      'SWING_MISSED'                  => ['missType', 'absorbed'],
      'RANGE_DAMAGE'                  => ['spellID', 'spellName' ,'spellSchool' ,'amount' ,'overkill' ,'school' ,'resisted' ,'blocked' ,'absorbed' ,'critical' ,'glancing' ,'crushing'],
      'RANGE_MISSED'                  => ['spellID', 'spellName', 'spellSchool', 'missType', 'blocked'],
      'SPELL_DAMAGE'                  => ['spellID', 'spellName' ,'spellSchool' ,'amount' ,'overkill' ,'school' ,'resisted' ,'blocked' ,'absorbed' ,'critical' ,'glancing' ,'crushing'],
      'SPELL_MISSED'                  => ['spellID', 'spellName', 'spellSchool', 'missType', 'absorbed'],
      'SPELL_HEAL'                    => ['spellID', 'spellName', 'spellSchool', 'amount', 'overheal', 'absorbed', 'critical'],
      'SPELL_ENERGIZE'                => ['spellID', 'spellName', 'spellSchool', 'amount', 'powerType'],
      'SPELL_PERIODIC_MISSED'         => ['spellID', 'spellName', 'spellSchool', 'missType', 'absorbed'],
      'SPELL_PERIODIC_DAMAGE'         => ['spellID', 'spellName' ,'spellSchool' ,'amount', 'overkill' ,'school' ,'resisted' ,'blocked' ,'absorbed' ,'critical' ,'glancing' ,'crushing'],
      'SPELL_PERIODIC_HEAL'           => ['spellID', 'spellName', 'spellSchool', 'amount', 'overheal', 'absorbed', 'critical'],
      'SPELL_PERIODIC_DRAIN'          => ['spellID', 'spellName', 'spellSchool', 'amount', 'powerType', 'extraAmount'],
      'SPELL_PERIODIC_LEECH'          => ['spellID', 'spellName', 'spellSchool', 'amount', 'powerType', 'extraAmount'],
      'SPELL_PERIODIC_ENERGIZE'       => ['spellID', 'spellName', 'spellSchool', 'amount', 'powerType'],
      'SPELL_DRAIN'                   => ['spellID', 'spellName', 'spellSchool', 'amount', 'powerType', 'extraAmount'],
      'SPELL_LEECH'                   => ['spellID', 'spellName', 'spellSchool', 'amount', 'powerType', 'extraAmount'],
      'SPELL_INTERRUPT'               => ['spellID', 'spellName', 'spellSchool', 'extraSpellID', 'extraSpellName', 'extraSpellSchool'],
      'SPELL_EXTRA_ATTACKS'           => ['spellID', 'spellName', 'spellSchool', 'amount'],
      'SPELL_INSTAKILL'               => ['spellID', 'spellName', 'spellSchool'],
      'SPELL_DURABILITY_DAMAGE'       => ['spellID', 'spellName', 'spellSchool'],
      'SPELL_DURABILITY_DAMAGE_ALL'   => ['spellID', 'spellName', 'spellSchool'],
      'SPELL_DISPEL_FAILED'           => ['spellID', 'spellName', 'spellSchool', 'extraSpellID', 'extraSpellName', 'extraSpellSchool'],
      'SPELL_DISPEL'                  => ['spellID', 'spellName', 'spellSchool', 'extraSpellID', 'extraSpellName', 'extraSpellSchool', 'auraType'],
      'SPELL_AURA_DISPELLED'          => ['spellID', 'spellName', 'spellSchool', 'extraSpellID', 'extraSpellName', 'extraSpellSchool', 'auraType'],
      'SPELL_AURA_STOLEN'             => ['spellID', 'spellName', 'spellSchool', 'extraSpellID', 'extraSpellName', 'extraSpellSchool', 'auraType'],
      'SPELL_AURA_APPLIED'            => ['spellID', 'spellName', 'spellSchool', 'auraType'],
      'SPELL_AURA_REMOVED'            => ['spellID', 'spellName', 'spellSchool', 'auraType'],
      'SPELL_AURA_APPLIED_DOSE'       => ['spellID', 'spellName', 'spellSchool', 'auraType', 'amount'],
      'SPELL_AURA_REMOVED_DOSE'       => ['spellID', 'spellName', 'spellSchool', 'auraType', 'amount'],
      'SPELL_CAST_START'              => ['spellID', 'spellName', 'spellSchool'],
      'SPELL_CAST_SUCCESS'            => ['spellID', 'spellName', 'spellSchool'],
      'SPELL_CREATE'                  => ['spellID', 'spellName', 'spellSchool'],
      'SPELL_SUMMON'                  => ['spellID', 'spellName', 'spellSchool'],
      'SPELL_CAST_FAILED'             => ['spellID', 'spellName', 'spellSchool', 'missType'],
      'DAMAGE_SHIELD'                 => ['spellID', 'spellName' ,'spellSchool' ,'amount' ,'overkill' ,'school' ,'resisted' ,'blocked' ,'absorbed' ,'critical' ,'glancing' ,'crushing'],
      'DAMAGE_SHIELD_MISSED'          => ['spellID', 'spellName', 'spellSchool', 'missType', 'absorbed'],
      'DAMAGE_SPLIT'                  => ['spellID', 'spellName' ,'spellSchool' ,'amount' ,'overkill' ,'school' ,'resisted' ,'blocked' ,'absorbed' ,'critical' ,'glancing' ,'crushing'],
      'ENCHANT_APPLIED'               => ['spellName', 'itemID', 'itemName'],
      'ENCHANT_REMOVED'               => ['spellName', 'itemID', 'itemName'],
      'ENVIRONMENTAL_DAMAGE'          => ['enviromentalType', 'amount', 'overkill', 'school', 'resisted', 'blocked', 'absorbed', 'critical', 'glancing', 'crushing'],
      'SPELL_AURA_REFRESH'            => ['spellID', 'spellName', 'spellSchool', 'auraType'],
      'PARTY_KILL'                    => [],
      'UNIT_DIED'                     => [],
      'UNIT_DESTROYED'                => []
      ];
      foreach(file($request->file('logfile')) as $line)
      {
      $line         = str_replace("nil",0,$line);
        list($stamps,$params)   = explode("  ", str_replace("\"","",$line)); //CleanUp - Split
        list($date,$time)       = explode(" ", $stamps);
        $time                   = str_replace(':', '', $time);
        $params                 = explode(",", $params);

        $event = array_shift($params);
        if($event == 'SPELL_MISSED' && !isset($params[10]))
          $params[10] = 0;
        if($event == 'RANGE_MISSED' && !isset($params[10]))
          $params[10] = 0;
        if($event == 'DAMAGE_SHIELD_MISSED' && !isset($params[10]))
          $params[10] = 0;
        if($event == 'SPELL_PERIODIC_MISSED' && !isset($params[10]))
          $params[10] = 0;
        if($event == 'SWING_MISSED' && !isset($params[7]))
          $params[7] = 0;
          $NormalEntry = array_combine($keysNormal, array_slice($params, 0, 6));
          $params = isset($keysByType[$event]) ? array_combine($keysByType[$event], array_slice($params,6)) : array_slice($params,6);
          DB::table('log_rows')->insert((['date'=>$date,'time'=>$time, 'event'=>$event, 'row_id'=>$i, 'log_id'=>$log_id] + $NormalEntry + $params));
      $i++;
      }
      DB::table('logs')->insert(['id'=>$log_id, 'content'=>$content, 'user_id'=>Auth::id(), 'realm'=>$realm, 'guild'=>$guild]);
    }
    return redirect('/logs');
}