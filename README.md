# overview
Minimalistic view layer for PHP applications

# why
Overview library is insipired by ZF2 Zend\View component. I was working on many ZF2 projects for some time and I liked ViewModel abstraction that is provided by Zend\View component. View model describes data and template name for given part of UI. View model can be rendered than by different types of renders. Models can be nested, which is convinient when you want to have one layout that has multiple view models rendered inside: content, sidebar, footer and so on.

The problem was that each time I tried to use Zend\View as standalone library, it was a pain to setup 
because of to many dependencies on other ZF2 components. That is why this little library came to existence.
