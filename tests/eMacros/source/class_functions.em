; class_functions.em
(:= _song (new stdClass))
(#name= _song "Meditango")
(#artist= _song "Astor Piazzolla")
(#genre= _song "Tango")

; get-object-vars
(get-object-vars _song) ; ["name" => "Meditango", "artist" => "Astor Piazzolla", "genre" => "Tango"]

; get-class
(get-class _song) ; "stdClass"

; instance-of
(instance-of _obj stdClass) ; true
(instance-of _obj ArrayObject) ; false

; is-a
(is-a _obj "stdClass") ; true
(is-a _obj "ArrayObject") ; false

; property-exists
(property-exists "eMacros\\Symbol" "package") ; true

; method-exists
(method-exists "ArrayObject" "count") ; true

; is-subclass-of
(is-subclass-of "eMacros\\Environment\\DefaultEnvironment" "eMacros\\Scope") ; true

; get-parent-class
(get-parent-class "eMacros\\Environment\\DefaultEnvironment") ; "eMacros\Environment\Environment"

; get-class-vars
(get-class-vars "eMacros\\Literal") ; ["value" => NULL]

; get-class-methods
(get-class-methods "eMacros\\Expression") ; ["evaluate"]

; class-alias
(class-alias "eMacros\\Symbol" "symbol")
(:= _song (new symbol "song"))