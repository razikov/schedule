<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\widgets\DatePicker;
use yii\web\View;

$this->title = 'Tests';
$this->registerJs('
    bindModal(".js-show-modal", {
        beforeShow: function (_modal) {
//            selectpicker(_modal);
        }
    });
');
?>

<div>
    <?php $form = ActiveForm::begin(['action' => [''], 'method' => 'get',]); ?>
    <section class="content-filters">
        <div class="css-xs-padding row">
            <div class="col-sm-4">
                <?= $form->field($searchModel, 'dateAt')->widget(
                    DatePicker::class, [
                        'format' => 'd.m.Y',
                        'options' => [
                            'class' => 'form-control',
                        ],
                        'params' => [
                            'weeks' => true,
                        ],
                    ]);
                ?>
            </div>
            <div class="col-sm-3">
                <div class="form-group"> 
                    <label for="" class="control-label">&nbsp;</label>
                    <div class="">
                        <?= Html::submitButton(Yii::t('app', 'Найти'), ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('app', 'Сброс'), [''], ['class' => 'btn btn-default']) ?>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php ActiveForm::end(); ?>
</div>

<?php
$width = 900; // $startX + 60 * 13 (часов, количество отображаемых часов)
//$height = 1500; // $headerY + 30 * $classroom * $n
$height = 30 + $total * 30 + 30;
$x = 10;
$y = 5;
$timeToInt = function ($time) {
    $value = explode(':', $time);
    return $value[0] * 60 + $value[1];
};
// 1 день = 1440 мин
// с 8 до 20, это 12 часов, это 720 минут, 8 часов это 480 минут.
$startX = 120;
$headerY = 30;
?>
<svg version="1.1"
     baseProfile="full"
     width="<?= $width ?>" height="<?= $height ?>"
     xmlns="http://www.w3.org/2000/svg">
    <?php for ($i = 8; $i <= 20; $i++) {
        $tx = $startX+$i*60-480;
        echo "<text x=\"".($tx+15)."\" y=\"".($y+15)."\">{$i} ч.</text>";
        echo "<line x1=\"{$tx}\" x2=\"{$tx}\" y1=\"0\" y2=\"".$height."\" stroke=\"blue\" stroke-width=\"1\" />";
    }
    $y += $headerY;
    ?>
    
    <?php foreach ($items as $classroom => $themes) : ?>
        <?php
            $x = 10;
            echo "<text x=\"{$x}\" y=\"".($y+15)."\">ауд. {$classroom}</text>";
            echo "<line x1=\"0\" x2=\"{$width}\" y1=\"".($y-5)."\" y2=\"".($y-5)."\" stroke=\"blue\" stroke-width=\"1\" />";
            if (!$themes) {
                $y += 30;
            }
        ?>
        <?php foreach ($themes as $key => $theme) : ?>
            <?php
                $x = $startX;
                $ws = $timeToInt($theme['start'])-480;
                $we = $timeToInt($theme['end'])-480;
                $rect = "<rect x=\"".($x+$ws)."\" y=\"{$y}\" width=\"".($we-$ws)."\" height=\"20\" stroke=\"black\" fill=\"green\" stroke-width=\"1\"/>";
                $text = "<text x=\"".($x+$ws+5)."\" y=\"".($y+15)."\">{$key}</text>";
                $y += 30;
            ?>
            <?= $rect ?>
            <?= Html::a($text, $theme['url'], ['class' => 'js-show-modal', 'alt' => $theme['hint']]) ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <?php
    echo "<line x1=\"0\" x2=\"{$width}\" y1=\"".($y-5)."\" y2=\"".($y-5)."\" stroke=\"blue\" stroke-width=\"1\" />";
    ?>
</svg>

