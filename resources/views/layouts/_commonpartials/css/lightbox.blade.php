<style type="text/css">
    .row > .column {
      padding: 0 8px;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    /* Create four equal columns that floats next to eachother */
    .column {
      float: left;
      width: auto;
    }

    /* The Modal (background) */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      padding-top: 100px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: black;
    }

    /* Modal Content */
    .modal-content {
      position: relative;
      background-color: #fefefe;
      margin: auto;
      padding: 0;
      width: 90%;
      max-width: 1200px;
    }

    .modal-content img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        height: 90vh;
        max-width: 100%;
    }


    /* Hide the slides by default */
    .mySlides {
      display: none;
      background-color: black;
    }

    /* Next & previous buttons */
    .prev,
    .next {
      color: white;
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      padding: 16px;
      margin-top: -50px;
      transition: 0.6s ease;
      user-select: none;
      -webkit-user-select: none;
      border-radius: 100%;
      will-change: transform;

    }

    /* Position the "next button" to the right */
    .prev {
      left: -75px;
    }
    .next {
      right: -75px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
        color: black;
        background-color: rgba(255, 255, 255, 0.8);
        transform: scale(1.5);
    }

    /* Number text (1/3 etc) */
    .closebutton {
      color: #f2f2f2;
      font-size: 12px;
      padding: 12px 12px;
      position: absolute;
      right: -75px;
      top: 0;
      border-radius: 100%;

    }

    /* The Close Button */
    .closebutton:hover,
    .closebutton:focus {
      color: black;
      background-color: white;
      text-decoration: none;
      cursor: pointer;
    }

    /* Caption text */
    .caption-container {
      text-align: center;
      background-color: black;
      padding: 2px 16px;
      color: white;
    }


    img.hover-shadow {
      transition: 0.3s;
    }

    .hover-shadow:hover {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
</style>