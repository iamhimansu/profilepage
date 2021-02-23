// (function(){
    "use strict";

    //Getting array as argument
    function focus(AllHtmlElements) {

     //Iterating through each element
      AllHtmlElements.forEach(elementus__element => {

        //Selecting the element
        const elementus__tags = document.querySelectorAll(elementus__element);

        //Looping through selected DOM tags
        elementus__tags.forEach(elementus__this_tag => {

            //Binding mouseover event over each element
          elementus__this_tag.addEventListener('mouseover', (e) => {

            //Adding a .backdrop class to body section
            document.body.classList.add('backdrop');

            //Focusing element by adding .selected class
            elementus__this_tag.classList.add('elementus','selected');

            //Binding mouseout event handler to the current element
            e.target.addEventListener('mouseout', () => {

                //Removing .selected class when mouse is away 
              elementus__this_tag.classList.remove('selected');

              //Resetting body to default
              document.body.classList.remove('backdrop');
            });

            // Stopping click events on focussed elements
            e.target.addEventListener('click', (evt) => {
              evt.stopPropagation();
            })
          });
        });
      });
    }

    //Running function
    // focus(FocusElements);

    //Start focusing on DOM update
    //Currently using jQuery
    $(document).bind('DOMNodeInserted', function() {
      focus(AllHtmlElements);
    });

  // })();
  