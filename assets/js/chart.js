var margin = {top: 50, right: 20, bottom: 50, left: 20 },
    width = parseInt(d3.select('#chart').style('width'), 10),
    width = width - margin.left - margin.right,
    height = parseInt(d3.select('html').style('height'), 10) - 80,
    height = height - margin.top - margin.bottom;

var rect_width = width >= 600 ? 100 : width/5,
    separation = (28/100)*rect_width, // Separation between rects
    atraction_bg = rect_width/2;

var title_size = width >= 600 ? "10.1rem" : width/5+"px",
    claim_size = width >= 600 ? "2rem" : width/15+"px";

var rect_array = 0, // Gamification
    color_array = [];

var force = d3.layout.force()
    .size([width, height])
    .charge(-400)
    .linkDistance(rect_width*3)
    .on("tick", tick);

var drag = force.drag()
    .on("dragstart", dragstart)
    .on("dragend", dragend);

var svg = d3.select("#chart").append("svg")
    .attr("width", width + margin.left + margin.right - 12)
    .attr("height", height + margin.top + margin.bottom - 12);

var g = svg.append('g')
  .attr("transform", "translate(" +margin.left+ "," +margin.top+ ")");

var node = g.append('g')
    .attr('class', 'nodes-group')
    .selectAll(".node");

var update = function(){};

d3.json("../wp-content/themes/aedisevilla-5scd/assets/data/graph3.json", function(error, graph) {
  if (error) throw error;

  // Calcule rows
  var rows = d3.max(graph.nodes, function(d) { return d.x; });
  var columns = d3.max(graph.nodes, function(d) { return d.y; });
  var block_width = (rect_width*rows) + (separation*(rows-1));

  // Parse data
  graph.nodes.forEach(function(d, i) {
    
    // Calcule positions where elements can de dropped
    d.p = [];
    graph.nodes.forEach(function(j, k) {
      if(d.fill == j.fill){
        var t = {};
        t.x = +j.x;
        t.y = +j.y;
        d.p.push(t)
      }
    });

    // Add color_array
    var alredy_color = color_array.indexOf(d.fill);
      if(alredy_color < 0){
        color_array.push(d.fill);
      }
  });

  // Set color Scale based in existings colors
  colorScale = chroma.scale(color_array).domain([0,color_array.length-1]);

  //Calcule position by given params
  graph.nodes.forEach(function(d, i) {    
      d.x = (+d.x-1)*rect_width + (+d.x-1)*separation + (width-block_width+rect_width)/2;
      d.y = (+d.y-1)*rect_width + (+d.y-1)*separation + (height-block_width)/2;

      d.p.forEach(function(j,k){
        j.x = +((+j.x-1)*rect_width + (+j.x-1)*separation + ((width-block_width+rect_width)/2));
        j.y = +((+j.y-1)*rect_width + (+j.y-1)*separation + ((height-block_width)/2));
      });
  });


  force
      .nodes(graph.nodes)
      .links(graph.links)
      .start();

  // Grid layout in the background
  var grey_group = g.append('g')
      .attr('class', 'grey-group')
      .style('pointer-events', 'none');

  grey_group.selectAll('rect')
    .data(function() { return graph.nodes })
    .enter()
  .append('rect')
    .attr('class', 'grey-back')
    .attr('x', function(d) { return d.x-(rect_width/2); })
    .attr('y', function(d) { return d.y-(rect_width/2); })
    .attr('width', rect_width)
    .attr('height', rect_width)
    .style('fill', 'transparent')
    .style('stroke', '#000')
    .style('stroke-width', '1px')
    .style('opacity', 0);

  node = node.data(graph.nodes)
    .enter().append("g")
      .attr("class", "node")
      .classed("fixed", function(d) { d.fixed = true; })
      .on("dblclick", dblclick)
      .call(drag);

  var node_group = node.append("g")
      .attr('transform', 'translate(' + (-rect_width/2) + ',' + (-rect_width/2) + ')')

  var node_back = node_group.append("rect")
      .attr("width", rect_width)
      .attr("height", rect_width)
      .style('fill', function(d) { return d.fill; });

  var rect_innershadow = node_group.append('polygon')
      .attr('points', '0,0 0,'+rect_width+' '+rect_width+',0')
      .style('opacity', 0.1)
      .style('fill', '#000');

  var text_group = g.append('g')
      .attr('transform', 'translate('+(width/2)+',' + (((block_width+height)/2)+72) + ')');

  text_group.append('text')
      .attr('class', 'title')
      .attr('text-anchor', 'middle')
      .style('font-size', title_size)
      .text('#5SCD');

  text_group.append('text')
      .attr('class', 'claim')
      .attr('transform', 'translate(' + 0 + ',' + 48 + ')')
      .attr('text-anchor', 'middle')
      .style('font-size', claim_size)
      .text("Let's touch");

  text_group.append('text')
      .attr('class', 'level level--label')
      .attr('text-anchor', 'start')
      .attr('transform', 'translate(' + (20+block_width/2) + ',' + 0 + ')')
      .style('font-size', claim_size)
      .style('opacity', '0')
      .text('Lvl');

  text_group.append('text')
      .attr('class', 'level level--value')
      .attr('text-anchor', 'start')
      .attr('transform', 'translate(' + (70+block_width/2) + ',' + 0 + ')')
      .style('font-size', claim_size)
      .style('opacity', '0')
      .text('0');

      
  

  update = function() {  
    for (var z = 1; z < 5;z++){
      new_node = {
          "x": 4,
          "y": +z,
          "p": [],
          "fill": colorScale(Math.floor((Math.random() * color_array.length))),
          "n": graph.nodes.length
        };

/* Uncomment to allow new elements been positioned in the grid

      // Calcule where can be dropped
      graph.nodes.forEach(function(j, k) {
        if(new_node.fill == j.fill){
          var t = {};
          t.x = +j.x;
          t.y = +j.y;
          new_node.p.push(t)
        }
      });
*/
      // Scale position
      new_node.x = (+new_node.x-1)*rect_width + (+new_node.x-1)*separation + (width-block_width+rect_width)/2 +margin.left;
      new_node.y = (+new_node.y-1)*rect_width + (+new_node.y-1)*separation + (height-block_width)/2 +margin.top;
      new_node.p.forEach(function(j,k){
        j.x = j.x+margin.left;
        j.y = j.y+margin.top;
      });

      graph.nodes.push(new_node);

    }

    node = svg.selectAll(".node")
        .data(force.nodes())

    node_enter = node.enter()
      .append("g")
        .attr("class", "node")
        .classed("fixed", function(d) { d.fixed = false; })
        .on("dblclick", dblclick)
        .call(drag);

    node_group = node_enter.append("g")
        .attr('transform', 'translate(' + (-rect_width/2) + ',' + (-rect_width/2) + ')')
        .attr('onclick', function() { ga('send', 'event', 'Game', 'play', 'drag'); });

    node_back = node_group.append("rect")
        .attr("width", rect_width)
        .attr("height", rect_width)
        .style('fill', function(d) { return d.fill; });

    rect_innershadow = node_group.append('polygon')
        .attr('points', '0,0 0,'+rect_width+' '+rect_width+',0')
        .style('opacity', 0.1)
        .style('fill', '#000');

    svg.selectAll(".node").classed("fixed", function(j) { j.fixed = false });
    svg.select(".level--value").text(function() {return parseInt(svg.select('.level--value').text())+1; })
    svg.select(".title").text("0");
    rect_array = [];

  force.start();


  }

});

function tick() {
  node.attr('transform', function(d) {
    return 'translate(' + d.x + ',' + d.y + ')';
  });
}


function dblclick(d) {
  d3.select(this).classed("fixed", d.fixed = false);
}

function dragstart(d) {
  d3.select(this).classed("fixed", d.fixed = true);
  svg.selectAll(".grey-back").transition().style('opacity', 0.3);
}

function dragend() {
  svg.selectAll(".grey-back").transition().style('opacity', 0);

  d3.select(this).classed("fixed", function(d) {
    var claim = d3.selectAll('.claim');
    var title = d3.selectAll('.title');
    var atracted = false;

    d.p.forEach(function(j, k){
      var alpha = Math.sqrt((Math.abs(d.x - j.x)*Math.abs(d.x - j.x))+(Math.abs(d.y - j.y)*Math.abs(d.y - j.y)));
      if(alpha <= atraction_bg && Array.isArray(rect_array)) {
        d.px = j.x;
        d.py = j.y;
        atracted = true;
      }
    })

    if(atracted){
      var alredy_pos = rect_array.indexOf(d.n);
      if(alredy_pos < 0){
        rect_array.push(d.n);
        switch(rect_array.length){
          case 1 : claim.text('Bien, bien, ese es el camino'); break;
          case 2 : claim.text('Uno menos!'); break;
          case 3 : claim.text('Olé'); break;
          case 4 : claim.text('Vamos, no pares!'); break;
          case 5 : claim.text('No pienses, actúa!'); break;
          case 6 : claim.text('Ya casi lo tienes!'); break;
          case 7 : claim.text('Un poco más!'); break;
          case 8 : claim.text('Vamosss!!!'); break;
          case 9 : claim.text("Where is your god now?"); update(); break;
        }
        svg.select(".title").text(function() { return parseInt(svg.select('.title').text())+1;})
      }else{
        claim.text('¿Qué estás intentando?');
      }

      d.fixed = true;
      return true;

    }else{
      svg.selectAll(".node").classed("fixed", function(j) { j.fixed = false });
      svg.selectAll(".level").transition().style('opacity', 1);
      rect_array = [];
      svg.select(".title").text('0');
      if(parseInt(svg.select('.level--value').text()) <= 0) claim.text('¿¡Pero qué has hecho!?');
      else claim.text('Eso no iba ahi!');
      return false;
    }
      
  })

}