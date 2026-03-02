@push('assetJs')
<script>
/*======================================================================
* CONSTANTS
*======================================================================*/

const ROUTE_URL = `{{ route('admin.dashboard') }}`;

const TYPE_LINE = 'line';

const GRAPH_YEAR = `{{ strtolower(\Globals::GRAPH_YEAR) }}`;
const GRAPH_MONTH = `{{ strtolower(\Globals::GRAPH_MONTH) }}`;
const GRAPH_WEEK = `{{ strtolower(\Globals::GRAPH_WEEK) }}`;

const MODEL_USER = `{{ \Globals::MODEL_USER }}`;
const MODEL_POST = `{{ \Globals::MODEL_POST }}`;

/*======================================================================
* INITIAL
*======================================================================*/
let canvasElements = document.querySelectorAll('.graph-view canvas');
let graphDate = document.getElementById('graph-date');

initializeCanvas();

let data = decodeEncodedString(`{{ json_encode($data) }}`);
populateDashboard(data);

/*======================================================================
* METHODS
*======================================================================*/

function initializeCanvas () {

  let ctxUser = document.getElementById('graph-user').getContext('2d');
  let ctxPost = document.getElementById('graph-post').getContext('2d');

  let config = {
    type: 'line',
    data: {
      labels: '',
      datasets: [
        {
          label: '',
          data: [],
          borderColor: 'blue',
          backgroundColor: 'rgba(0, 123, 255, 0.5)',
          pointStyle: 'circle',
          pointRadius: 1,
          pointHoverRadius: 15
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: (ctx) => 'Point Style: ' + ctx.chart.data.datasets[0].pointStyle,
        }
      }
    }
  };

  let userCanvas = new Chart (ctxUser, config);
  let postCanvas = new Chart (ctxPost, config);
}

function showGraphByModel () {
  let model = document.getElementById('graph-model').value;

  canvasElements.forEach(function(canvas) {
    let canvasModel = canvas.getAttribute('for').toLowerCase();

    if (model == canvasModel) {
      canvas.style.display = 'block';
    } else {
      canvas.style.display = 'none';
    }
  });
}

function toggleDropdown() {
 var dropdownContent = document.getElementById("dropdownContent");
 dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
}

function getGraphByDate(event) {
  const graphDate = document.getElementById('graph-date').value;
  const filterParam = new URLSearchParams();
  filterParam.append('graph_date', graphDate);

  fetch(ROUTE_URL + "?" + filterParam)
    .then(data => data.json())
    .then((response) => {
      // Process the received data
      populateDashboard(response);
    })
    .catch(error => {
      // Handle any errors
      console.error('Error:', error);
    });
};

function createChart (elementCanvas, serverData, datasetsLabel, labels) {
  const ctx = elementCanvas.getContext('2d');
  const type = elementCanvas.getAttribute('line') === TYPE_LINE ? TYPE_LINE : 'line';
  const elAttribute = datasetsLabel.toLowerCase() + 'Canvas';
  const canvas = {
    'userCanvas': Chart.getChart('graph-user'),
    'postCanvas': Chart.getChart('graph-post')
  };

  const chart = canvas[elAttribute];
  chart.type = type;
  chart.data.labels = labels;
  chart.data.datasets[0].data = serverData;
  chart.data.datasets[0].label = datasetsLabel;
  chart.update();
}

function populateDashboard(data) {
  document.getElementById('total-user').innerHTML = data.totalUser;
  document.getElementById('total-post').innerHTML = data.totalPost;
  document.getElementById('total-category').innerHTML = data.totalCategory;

  const elementCanvas = document.querySelectorAll('.graph-view canvas');
  elementCanvas.forEach((canvas) => {
    const datasetsLabel = canvas.getAttribute('for');
    let labels = [];
    let monthlyCount = [];

    if (datasetsLabel === MODEL_POST) {
      labels = Object.keys(data.post);
      monthlyCount = Object.values(data.post);
    } else if (datasetsLabel === MODEL_USER) {
      labels = Object.keys(data.user);
      monthlyCount = Object.values(data.user);
    }

    createChart(canvas, monthlyCount, datasetsLabel, labels);
    showGraphByModel();
  });
}

function decodeEncodedString(encodedString) {
  const decodedString = decodeURIComponent(encodedString.replace(/&quot;/g, '"'));
  return JSON.parse(decodedString);
}
/*======================================================================
* DOM EVENTS
*======================================================================*/
</script>
@endpush