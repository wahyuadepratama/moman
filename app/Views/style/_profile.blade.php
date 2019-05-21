<style media="screen">
  .table {
    border: none !important;
    border-color: white !important;
  }
  .table td{
    border: none !important;
    border-color: white !important;
    padding: 2% !important;
  }
  .content-wrapper {
    padding: 3% !important;
  }
  
  /* icon avatar */
  .hover-image {
    position: relative;
    width: 50%;
    border-radius: 50%
  }
  .hover-image-radius {
    display: block;
    width: 100%;
    height: auto;
  }
  .overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    transition: .5s ease;
    background-color: #ffffff70;
  }
  .hover-image:hover .overlay {
    opacity: 1;
  }
  .hover-image-icon {
    color: white;
    font-size: 50px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
  }
</style>
