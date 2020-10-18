'use strict';

const ruleImage = $('#rule-image');
const pre = $('.prev');
const next = $('.next');
let i = 1;

// カルーセル
pre.on('click', ()=>{
  if(i > 1){
    i--;
    $('.carousel')
    .children('img')
    .attr('src',`img/rule${i}.png`);
    $(`.rule-text${i+1}`).css('display','none');
    $(`.rule-text${i}`).css('display','block');
  }
})
next.on('click',()=>{
  if(i < 4){
    i++;
    $('.carousel')
    .children('img')
    .attr('src',`img/rule${i}.png`)
    $(`.rule-text${i-1}`).css('display','none');
    $(`.rule-text${i}`).css('display','block');
  }
})

const htmlWords = [
  'base','head','body','li','ul','link','style','input','meta','title','address','article',
  'aside','footer','header','hgroup','main','nav','section','blockquote','dd','div',
  'dl','dt','figcaption','figure','hr','pre','br','bdi','cite','data','dfn','kbd','mark',
  's','sub','area','track','script','noscript','label','option','output','progress','textarea',
  'menu','summary','element','strong','small','span','audio','video','table','type="radio"','type="text"',
  'type="submit"','type="checkbox"','type="email"','type="number"','type="tel"','type="url"',
  'type="password"','type="hidden"','!DOCTYPE html','html lang="jp"','charset="UTF-8"'
];
const cssWords = [
  ':active','align-items','animation-delay','animation-direction','animation-fill-mode',
  'animation-name','attr()','background-image','background-color','background-size',
  ':before','border-block-color','border-block-end-style','border-block-start-width',
  'border-bottom-left-radius','border-spacing','box-shadow','break-after',
  ':checked','clear','clip-path','columm-count','content','cursur',':disabled',
  'display','dpi','element()',':empty','filter',':first','flex','float','font-family',
  'font-weight','grid-row',':hover','height','image()','inset()',':lang','list-style','margin',
  '@media',':ntn-child','opacity','outline','padding','rgb()',':valid','color','font-size','text-align',
  'line-height','text-decoration','letter-spacing','text-indent','list-style-type','list-style-position',
  'list-style-image','background-repeat','background-position','vertical-align','','',''
];
const jsWords = [
  'block','break','continue','pop()','swith','push()','throw','let','const','function',
  'return','map()','for','forEach()','filter()','while','import','debugger',
  'label','with','this','yield','await','new.target','super','null',
  'A++','A--','delete','void','typeof','instanceof','<=','>=','!==','&&','||','reduce()',
  'shift()','setDate()','Math.log()','.keys()','link()','.getElementById()','createElement()',
  'querySelector()','preventDefault()','unshift()','slice()','splice()','concat()','indexOf()',
  'includes()','find()','sort()','reverse()','isNaN()','Math.ceil()','Math.floor()','Math.random()',
  'Math.round()','Date.now()','Array()'
];
const phpWords = [
  'require()','include_once()','htmlspecialchars()','str_replace()','preg_match()','nl2br()',
  'mb_strlen()','mb_substr()','header()','preg_match_all()','trim()','unset()','in_array()',
  'mb_strimwidth()','mb_convert_kana()','array_unique()','str_replace()','file_exists()',
  'sprintf()','explode()','implode()','isset()','empty()','$_GET','$_POST','$_SESSION','$_REQEST',
  '$_SERVER','session_start()','$_COOKIE','var_dump()','echo','file()','error_repoting','error_log',
  'random_bytes()','hash()','date()','mktime()','strtotime()','fopen()','fwrite()','fclose()',
  'fputs()','fread()','flock()','file_get_contents()','file_put_contents()','fgets()','ceil()',
  'floor()','max()','min()','json_decode()','json_encode()','session_id()','session_destroy()',
  'htmlspecialchars()','print()','printf()','is_numeric()','is_int()','is_string()','is_null()'
]

let words;
let word;
let loc;
let score;
let miss;
const timelimit = 60 * 1000; //変える
let startTime;
let isPlaying = false;
$('.result').hide();

// 正解した文字を_に変える
const updateTarget = () => {
  let placeholder = '';

  for(let i = 0; i <loc; i++){
    placeholder += '_';
  }
  let oktext = placeholder + word.substring(loc);
  $('#target').text(`${oktext}`);
}

// 結果画面の表示
const showResultScren = ()=>{
  $('.main').hide();
  $('.result').show();

  const accuracy = score + miss === 0 ? 0 :  Math.floor(score / (score + miss) * 100);

  $('.score').text(`Letter count:${score}`);
  $('.miss').text(`Miss count:${miss}`);
  $('#percentage').text(`accuraty:${accuracy}%`);
  rank(score);
}

// 結果の評価方法
const rank = ()=> {
  if(score >= 120){
    $('.rank').text('Excellent');
  } else if (score >= 100){
    $('.rank').text('Very Good');
  }else if (score >= 80){
    $('.rank').text('Good');
  }else if (score >= 70){
    $('.rank').text('Average');
  }else if (score < 50){
    $('.rank').text('Poor');
  };
}

const title = $('#target').attr('value');

// 結果画面から元の画面への切り替え
$('.replay').on('click',()=>{
  $('.result').hide();
  $('.start').css({ display: 'inline-block' });
  $('#target').text(title);
  $('.main').show();
})

// タイマーについて
const updateTimer = () => {
  const timeLeft = startTime + timelimit - Date.now();
  let timeLestText = (timeLeft/1000).toFixed(2);
  $('#timer').text(`${timeLestText}`);

  const timeoutId = setTimeout(()=>{
    updateTimer();
  },10);

  if(timeLeft < 0){
    isPlaying = false;
    clearTimeout(timeoutId);
    $('#timer').text('0.00');

    showResultScren(score,miss);
  }
}

// スタートボタン押した時のイベント
$('.start').on('click' , () => {
  if(isPlaying === true){
    return;
  }
  isPlaying = true;

  $('.start').css({ display: 'none' });
  
  loc = 0;
  score = 0;
  miss = 0;
  $('#score').text(`${score}`);
  $('#miss').text(`${miss}`)

  if(document.getElementById('css')){
    words = cssWords;
  } else if (document.getElementById('html')) {
    words = htmlWords;
  } else if (document.getElementById('js')){
    words = jsWords;
  } else if (document.getElementById('php')){
    words = phpWords;
  };

  word = words[Math.floor(Math.random() * words.length)];

  $('#target').text(`${word}`);
  startTime = Date.now();
  updateTimer();
});

// タイピングしてる時
window.addEventListener('keydown',e => {
  if(isPlaying !== true){
    return;
  }

  if(e.key === word[loc]){
    loc++;
    if(loc === word.length){
      word = words[Math.floor(Math.random() * words.length)];
      loc = 0;
    }
    updateTarget();
    score++;
    $('#score').text(score);

  }  else if (e.shiftKey){
    $('.main').css('background-color', '#fff');
  } else {
    // 背景赤に
    $('.main').css('background-color', 'rgba(255, 0, 0, 0.7)');
    setTimeout(function(){
      $('.main').css('background-color', '#fff');
    },100);
    miss++;
    $('#miss').text(miss);
  }
});