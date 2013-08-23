/**
 * Adobe Edge: symbol definitions
 */
(function($, Edge, compId){
//images folder
var im='images/';

var fonts = {};
   fonts['muli, sans-serif']='<script src=\"http://use.edgefonts.net/muli:n3,i4,i3,n4:all.js\"></script>';


var resources = [
];
var symbols = {
"stage": {
   version: "1.5.0",
   minimumCompatibleVersion: "1.5.0",
   build: "1.5.0.217",
   baseState: "Base State",
   initialState: "Base State",
   gpuAccelerate: false,
   resizeInstances: false,
   content: {
         dom: [
         {
            id:'Text2',
            type:'text',
            rect:['12px','12px','568px','157px','auto','auto'],
            opacity:0,
            text:"We started on the road.  A traveling circus of misfits and mishaps.  <br>Today we are a collective of skilled artists, talented designers, <br>organized project managers and amazing fabricators.  <br>From start to finish we can handle your project, and along <br>the way we will share our stories.<br>With over 20 artist and over 30,000 Square ft of indoor and <br>outdoor shop space containing a wood shop, metal shop, paint <br>shop, CNC routing room, 3d design offices and a model making <br>shop, One Hat One Hand is fully equipped to take on just about <br>any concept.",
            align:"center",
            font:['muli, sans-serif',12,"rgba(0,0,0,1)","normal","none","normal"]
         },
         {
            id:'Text3',
            type:'text',
            rect:['12px','233px','568px','180px','auto','auto'],
            opacity:0,
            text:"With a portfolio full of pop up experiential marketing, large <br>scale sculptures, sets and props for photo shoots and TV <br>commercials, interior designs and installations for bars and <br>restaurants, along with so many other unique opportunities, <br>we like to think of ourselves as a business that doesn’t say no.  <br>If we don’t know how, we learn,  if we don’t have the talent, <br>we hire them, and if we don’t have the tools we buy them.  We <br>stand by what we do and we get things done;  On time. <br>By embracing a large community of local artists and a <br>desire to share art and the process of making it with our <br>community One Hat One Hand creates a unique experience <br>for all involved!  ",
            align:"center",
            font:['muli, sans-serif',12,"rgba(0,0,0,1)","normal","none","normal"]
         }],
         symbolInstances: [

         ]
      },
   states: {
      "Base State": {
         "${_Stage}": [
            ["color", "background-color", 'rgba(255,255,255,1)'],
            ["style", "width", '100%'],
            ["style", "height", '100%'],
            ["style", "overflow", 'hidden']
         ],
         "${_Text2}": [
            ["style", "top", '12px'],
            ["style", "opacity", '0'],
            ["style", "text-align", 'center'],
            ["style", "display", 'block'],
            ["style", "height", '157px'],
            ["style", "font-family", 'muli, sans-serif'],
            ["style", "left", '12px'],
            ["style", "font-size", '12px']
         ],
         "${_Text3}": [
            ["style", "top", '233px'],
            ["style", "opacity", '0'],
            ["style", "left", '12px']
         ]
      }
   },
   timelines: {
      "Default Timeline": {
         fromState: "Base State",
         toState: "",
         duration: 11250,
         autoPlay: true,
         timeline: [
            { id: "eid31", tween: [ "style", "${_Text2}", "opacity", '1', { fromValue: '0.000000'}], position: 0, duration: 1000 },
            { id: "eid29", tween: [ "style", "${_Text3}", "opacity", '0', { fromValue: '0'}], position: 0, duration: 0 },
            { id: "eid32", tween: [ "style", "${_Text3}", "opacity", '0', { fromValue: '0'}], position: 1000, duration: 0 },
            { id: "eid34", tween: [ "style", "${_Text3}", "opacity", '1', { fromValue: '0.000000'}], position: 10250, duration: 1000 }         ]
      }
   }
}
};


Edge.registerCompositionDefn(compId, symbols, fonts, resources);

/**
 * Adobe Edge DOM Ready Event Handler
 */
$(window).ready(function() {
     Edge.launchComposition(compId);
});
})(jQuery, AdobeEdge, "EDGE-162954122");
