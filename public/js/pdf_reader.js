//first needs to load pdf min and pdf worker

let currentScale = 2;
let currentRotation = 0;
let currentPage = 1;
let totalPages = 0;
let pages = []; // Array to store the rendered pages

function load_pdf_reader(documentUrl) {

  loadDocument(documentUrl);
  
  //Disable the context menu
  window.addEventListener("contextmenu", function (e) {
    e.preventDefault();
  });

}


function loadDocument(url) {
  pdfjsLib.getDocument(url).promise.then(function (pdf) {
    const pdfContainer = document.getElementById("pdf-container");
    const innerContainer = document.createElement("div");
    innerContainer.className = "pdf-inner-container";
    innerContainer.id = "pdf-inner-container";

    const container = document.createElement("div");
    container.className = "pdf-pages";
    container.id = "pdf-pages";

    totalPages = pdf.numPages;
    pdfdoc = pdf;
    
    // Render all pages
    // for (let pageNumber = 1; pageNumber <= totalPages; pageNumber++) {
    //   renderPage(pdf, container, pageNumber, currentScale, currentRotation);
    // }

    //default render 1 page
    renderPage(pdf, container, 1 , currentScale, currentRotation);

    function adjustPageHeight() {
      const pageHeight = 600 * currentScale; // Adjust the page height as needed
      pages.forEach((page) => {
        page.style.height = `${pageHeight}px`;
      });
    }

    function updatePages() {
      pages.forEach((page) => {
        const pageNumber = parseInt(page.dataset.pageNumber);
        renderPage(pdf, container, pageNumber, currentScale, currentRotation);
      });
      adjustPageHeight();
    }

    // Render a specific page
    function renderPage(pdf, container, pageNumber, scale, rotation) {
      pdf.getPage(pageNumber).then(function (page) {
        const viewport = page.getViewport({ scale, rotation });
        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d");
        // canvas.width = viewport.width * 0.8;
        canvas.width = viewport.width;
        canvas.height = viewport.height;
        canvas.className = "pdf-page";
        canvas.dataset.pageNumber = pageNumber;
        // pages.push(canvas); // Store the rendered page in the array

        // Render the page contents in the canvas
        page.render({
          canvasContext: context,
          viewport: viewport,
          renderInteractiveForms: true, // Enable interactive form rendering
          renderTextLayer: false, // Disable text layer rendering for better performance
          renderMode: 'print', // Use 'print' quality for high-quality rendering
        });

        // Append the canvas to the container
        container.appendChild(canvas);
      });
    }

    innerContainer.appendChild(container);
    pdfContainer.appendChild(innerContainer);

    // Add an event listener to the pdf-container for scroll events
    document.getElementById("pdf-container").addEventListener("scroll", function() {
      const pdfContainer = this;
      const scrollHeight = pdfContainer.scrollHeight;
      const scrollTop = pdfContainer.scrollTop;
      const clientHeight = pdfContainer.clientHeight;

      // Check if the scroll position is near the bottom (adjust the threshold as needed)
      if (scrollHeight - scrollTop - clientHeight < 100) {
        // Load the next set of pages (e.g., the next 2 pages)
        const nextPageStart = currentPage + 1;
        const nextPageEnd = Math.min(currentPage + 2, totalPages);

        for (let pageNumber = nextPageStart; pageNumber <= nextPageEnd; pageNumber++) {
          renderPage(pdf, pdfContainer.querySelector(".pdf-pages"), pageNumber, currentScale, currentRotation);
        }

        // Update the current page
        currentPage = nextPageEnd;
      }
    });
    
  })
  .catch(function (error){
    const pdfContainer = document.getElementById("pdf-container");
    const innerContainer = document.createElement("div");
    innerContainer.className = "pdf-inner-container";
    innerContainer.id = "pdf-inner-container";
    innerContainer.innerHTML = "<h5 style='color:#ccc;margin-top:4rem;text-align:center;'> The Document File Could Not Be Loaded...</h5>";
    
    pdfContainer.appendChild(innerContainer);
  });
}
