
@extends('layouts.user')

@section('content')
      

    <div class="main-container bg-gray-100 h-100 p-[15px]">
    
      <!-- Dashboard Header -->

      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
        <div>
            <h1 class="text-3xl font-extrabold text-dark">Dashboard</h1>
            <p class="text-base text-dark mt-1 mb-3">Stocks Overview &amp; Item Search</p>
        </div>
      </div>

        <!-- Table Header -->
        <div class=" gap-2 rounded-md gap-30 flex items-start">
            <div class="relative w-full flex-grow sm:flex-grow-0">
                <input type="text" id="searchInput"
                    class="w-full sm:w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search Item">
                <svg class="absolute right-3 top-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 1 0-12 0 6 6 0 0 0 12 0z"/>
                </svg>
            </div>
        </div>
         
            <!-- Stocks Table -->
            <div class="bg-white rounded-md overflow-hidden shadow-md">
                <div class="overflow-x-auto px-3">
                    <table class="min-w-full bg-white divide-y divide-gray-200">
                        <thead class="bg-white tracking-wide">
                            <tr>
                                
                                <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">No.</th>
                                <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Item Name </th>
                                <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">variant value</th>
                                <th class="px-3 py-3 text-left text-sm text-gray-600 uppercase">Stocks</th>


                            </tr>
                        </thead>
                        <tbody id="stockTbody" class="divide-y divide-gray-200">
                            @foreach ($stocks as $stock)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-3 text-gray-800 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-3 py-3 text-gray-800 font-medium capitalize">{{ $stock->item_name }}</td>
                                <td class="px-3 py-3 text-gray-800 font-medium capitalize">{{ $stock->variant_value }}</td>
                            
                                <td class="px-3 py-3 text-gray-800 font-medium">
                                    @if ($stock->stock_quantity == 0)
                                        <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                            Out of stock
                                        </span>
                                    @elseif ($stock->stock_quantity < 20)
                                        <span class="px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                            Low stock ({{ $stock->stock_quantity }})
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                            {{ $stock->stock_quantity }} in stock
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tr id="no-requests-row" style="display: none;">
                            <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                              No requests found.
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
 
    </div>

  

    <script>
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', filterRequests);
    
    
      function filterRequests() {
    
        const searchValue = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('#stockTbody tr');
        let visibleCount = 0;
    
        rows.forEach(row => {
          // Skip the "No request" row
          if (row.id === 'no-requests-row') return;
    
          const nameCell = row.querySelector('td:nth-child(2)');
    
          const matchesSearch = nameCell.textContent.toLowerCase().includes(searchValue);
    
          if (matchesSearch) {
            row.style.display = '';
            visibleCount++;
          } else {
            row.style.display = 'none';
          }
        });
    
        // Show/hide the "no requests" message
        const noResultsRow = document.getElementById('no-requests-row');
        if (visibleCount === 0) {
          noResultsRow.style.display = '';
          if (searchValue !== 'all') {
            noResultsRow.querySelector('td').textContent = `No requests found.`;
          }
        } else {
          noResultsRow.style.display = 'none';
        }
      }
    document.addEventListener('DOMContentLoaded', () => {
        // Check if Admin has approved
        const adminApproved = document.querySelector('.step .approved[data-step="admin"]');

        if (adminApproved) {
            // Add reset class to the progress steps and lines
            const steps = document.querySelectorAll('.step .circle');
            const lines = document.querySelectorAll('.line');
            
            steps.forEach((step) => step.classList.add('reset'));
            lines.forEach((line) => line.classList.add('reset'));
        }
    });


    document.addEventListener('DOMContentLoaded', function() {
    const sortHeader = document.getElementById('sortItemName');
    const sortIcon = document.getElementById('sortIcon');
    const tbody = document.getElementById('stockTbody');
    let sortAsc = true; // initial sort order

    sortHeader.addEventListener('click', function() {
      // Get table rows as an array
      const rows = Array.from(tbody.querySelectorAll('tr'));

      // Sort rows based on the text in the second cell (item name)
      rows.sort((a, b) => {
        const aText = a.cells[1].textContent.trim().toLowerCase();
        const bText = b.cells[1].textContent.trim().toLowerCase();

        if (aText < bText) return sortAsc ? -1 : 1;
        if (aText > bText) return sortAsc ? 1 : -1;
        return 0;
      });

      // Remove existing rows and append sorted rows
      tbody.innerHTML = '';
      rows.forEach(row => tbody.appendChild(row));

      // Toggle sort order for next click
      sortAsc = !sortAsc;

      // Rotate sort icon to indicate sort order
      sortIcon.classList.toggle('rotate-180', !sortAsc);
    });
  });

    var itemNames = @json($itemNames);  // This will hold the item names


        var quantities = @json($quantities);  // This will hold the stock quantities
        
        // Define the threshold for low stock
        var lowStockThreshold = 40;
        
        // Glassy color styles for red and teal
        var glassyRed = 'rgba(255, 0, 0, 0.5)'; // Semi-transparent red
        var glassyTeal = 'rgba(0, 128, 128, 0.5)'; // Semi-transparent teal
        
        // Separate the data into two categories: low and high
        var lowStockData = quantities.map(quantity => quantity <= lowStockThreshold ? quantity : null);
        var highStockData = quantities.map(quantity => quantity > lowStockThreshold ? quantity : null);
        
        // Adjust for high resolution
        function setCanvasResolution(canvas) {
            const ctx = canvas.getContext('2d');
            const pixelRatio = window.devicePixelRatio || 1;
        
            // Set canvas width and height to match pixel ratio
            canvas.width = canvas.offsetWidth * pixelRatio;
            canvas.height = canvas.offsetHeight * pixelRatio;
        
            // Scale the drawing context
            ctx.scale(pixelRatio, pixelRatio);
        }
        
        // Select the canvas
        const canvas = document.getElementById('stockChart');
        setCanvasResolution(canvas);
        
        // Create the chart
        var ctx = canvas.getContext('2d');
        var stockChart = new Chart(ctx, {
            type: 'bar',  // Use a bar chart
            data: {
                labels: itemNames,  // Use item names as labels for the X-axis
                datasets: [
                    {
                        label: 'Low Stocks',  // Label for low stock (red)
                        data: lowStockData,  // Data for low stock
                        backgroundColor: glassyRed,  // Glassy effect for low stock
                        borderColor: 'rgba(255, 0, 0, 0.8)',  // Border with higher opacity
                        borderWidth: 1,  // Border thickness
                        borderRadius: 5,  // Rounded corners
                        barThickness: 15  // Bar width
                    },
                    {
                        label: 'High Stocks',  // Label for high stock (teal)
                        data: highStockData,  // Data for high stock
                        backgroundColor: glassyTeal,  // Glassy effect for high stock
                        borderColor: 'rgba(0, 128, 128, 0.8)',  // Border with higher opacity
                        borderWidth: 1,  // Border thickness
                        borderRadius: 5,  // Rounded corners
                        barThickness: 15  // Bar width
                    }
                ]
            },
            options: {
                responsive: true,  // Make the chart responsive
                maintainAspectRatio: false,  // Allow flexible resizing
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#333',  // Dark gray for legend text
                            font: {
                                size: 14,  // Adjust font size
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,  // Ensure that the Y-axis starts from zero
                        ticks: {
                            color: '#666',  // Medium gray for Y-axis labels
                            font: {
                                size: 15, // Adjust font size
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: false  // Hide vertical grid lines
                        }
                    },
                    x: {
                        ticks: {
                            color: '#666',  // Medium gray for X-axis labels
                            font: {
                                size: 12, // Adjust font size
                   
                            },
                            autoSkip: false,  // Ensure all labels are displayed
                        },
                        grid: {
                            color: '#ddd'  // Light gray for grid lines
                        }
                    }
                }
            }
        });
        



</script>


@endsection

   

