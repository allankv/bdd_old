<html>
    <head>
        <script src="http://www.google.com/jsapi?key=ABQIAAAA1XbMiDxx_BTCY2_FkPh06RRaGTYH6UMl8mADNa0YKuWNNa8VNxQEerTAUcfkyrr6OwBovxn7TDAH5Q"></script>
        <script type="text/javascript">
            // This code generates a "Raw Searcher" to handle search queries. The Raw Searcher requires
            // you to handle and draw the search results manually.
            google.load('search', '1');

            var localSearch;
            function searchComplete() {

              // Check that we got results
              document.getElementById('localresult').innerHTML = '';
              if (localSearch.results && localSearch.results.length > 0) {
                for (var i = 0; i < localSearch.results.length; i++) {

                  // Create HTML elements for search results
                  var localresult = document.getElementById('localresult');
                  var country = document.createElement('country');
                  var region = document.createElement('region');
				  var city = document.createElement('city');
				  var locality = document.createElement('locality');
				  var lat = document.createElement('lat');
				  var lng = document.createElement('lng');

                  country.innerHTML = localSearch.results[i].country;
				  region.innerHTML = localSearch.results[i].region;
				  city.innerHTML = localSearch.results[i].city;
				  locality.innerHTML = localSearch.results[i].title;
				  lat.innerHTML = localSearch.results[i].lat;
				  lng.innerHTML = localSearch.results[i].lng;

                  // Append search results to the HTML nodes
                  localresult.appendChild(country);
                  localresult.appendChild(region);
                  localresult.appendChild(city);
				  localresult.appendChild(locality);
				  localresult.appendChild(lat);
				  localresult.appendChild(lng);
                  document.body.appendChild(localresult);
                }
              }
            }

            function search() {

              // Create a LocalSearch instance.
              localSearch = new google.search.LocalSearch();

              // Set the Local Search center point
              localSearch.setCenterPoint('America');

              localSearch.setResultSetSize(google.search.Search.LARGE_RESULTSET);
              // Set searchComplete as the callback function when a search is complete. The
              // localSearch object will have results in it.
              localSearch.setSearchCompleteCallback(this, searchComplete, null);

              // Specify search quer(ies)
              localSearch.execute(document.getElementById('parametro').innerHTML);

              // Include the required Google branding.
              // Note that getBranding is called on google.search.Search
              //google.search.Search.getBranding('local');
            }

            // Set a callback to call your code when the page loads
            google.setOnLoadCallback(onLoad);
        </script>
    </head>
    <body>
        <div id="parametro"><?php echo isset ($_GET['q'])?$_GET['q']:isset ($_POST['parametro'])?$_POST['parametro']:'brazil';?></div>
        <div id="localresult"></div>
    </body>
</html>

