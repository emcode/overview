# overview
Minimalistic view layer for PHP applications

# why
Overview library is insipired by ZF2 Zend\View component. I was working on many ZF2 projects for some time and I liked 
ViewModel abstraction that is provided by Zend\View component. View model describes data and template name for given
part of UI. View model can be rendered than by differend types of renders. View models can be nested, which is 
convinient when you want to have one layout that have multiple view models rendered inside: content, sidebar, footer and so on.

The problem was that each time when I tried to use Zend\View component of ZF2 framework as standalone library it was a pain to setup 
because of dependencies on other ZF2 components. I wantend to use this idea in projects that are not based on ZF2. 
