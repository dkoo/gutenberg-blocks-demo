# Anatomy of a Gutenberg Block: Demo

This plugin is a quick demo of a static and dynamic Gutenberg block, built for my presentation to the 10up front-end engineering team as part of our shared learning initiative.

The block code is based off of [this tutorial](https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/) from the [Gutenberg Block Editor Handbook](https://developer.wordpress.org/block-editor/).

The plugin code is loosely based off of [10up's plugin scaffold](https://github.com/10up/plugin-scaffold).

To install this plugin, clone this repository to your WordPress `plugins` folder and run `npm run start` from the root directory. Activate the "Derrick’s Test Block" plugin in WordPress.

Detailed speaker notes from my presentation are below:

# ANATOMY OF A GUTENBERG BLOCK: SPEAKER NOTES

Everything you need to build a Gutenberg block from scratch

Looks a lot like any WordPress functionality:

* PHP
* JS
* Optionally, CSS

But the JS is doing a lot more heavy lifting here

Notice I didn’t say ALL of the heavy lifting. PHP still plays a huge role in Gutenberg blocks especially as we’ll see with dynamic blocks

Two types of blocks:

The primary difference is how they get their CONTENT

* Static, or regular - handles block content via JS (client-side rendering)
* Dynamic - handles block content via PHP (basically, server-side rendering)

## Let’s talk about STATIC BLOCKS

This is the most basic type of Gutenberg block

Almost all important functions are delegated to the JS

Lots of shortcomings with static blocks

* No server-side rendering
* Content is stored as part of the rendered output of the block
* The rendered output is stored in the DB as static strings within the post’s content field
* This means that if you change the rendered output, you can introduce a conflict between the expected output (saved in the DB) and the rendered output (rendered by JS)
* This results in the dreaded “This block contains unexpected or invalid content” JS error
* Puts the onus of resolving conflicts on content editors
* A messy experience overall
* If your site is mostly built out of static blocks, you’re going to have a bad time whenever you need to update your block code

That said,

### Let’s talk about ANATOMY OF A STATIC BLOCK

Step 1: PHP

* Register the block script - the JavaScript that controls the block editing and render functions
* Define its dependencies
* Register the block itself
* Give it the script ID you registered

Step 2: CSS

* If you want to use external CSS for your block, you can provide a registered CSS file for the editor and the front-end
* In this case it’s the same file - this makes it easy to share code across front-end and back-end
* You should probably use the enqueue_block_assets hook as Evan described earlier—this was not part of the handbook when I was building this demo
* Alternatively, you can keep your styles inline in the block JS, but this gets messy for more complex blocks
* Gutenberg is basically React, right? What about Styled Components or other cool React styling methodologies?
* Unfortunately, Gutenberg doesn’t provide an easy way to use these
* Gutenberg may rely on React principles but it doesn’t actually use React or ReactDOM on the front-end - static blocks are HTML STRINGS on the front-end, nothing more
* There’s also still an absolute separation between front-end and back-end. Even if you manually load React on the front-end, it’s not the same session as on the back-end so it doesn’t have direct access to things like component props or state for the block
* Right now, there’s no good solution for this yet

### Let’s move on to THE JS

The JS file is where all the heavy lifting happens

All starts with invoking registerBlockType

Two arguments:

* Unique ID string with namespace matching plugin or theme
* This is so that if you name your custom block “paragraph” it doesn’t conflict with another block with ID “paragraph”
* Second argument is a configuration object

Within this object, every block needs several basic pieces:

* Meta - this is where you define meta info about the block such as the name and category it appears in within the editor
* Attributes - In a static block, this is basically your content and other attributes needed to render that content, such as in this case text alignment
* Edit function - Everything needed to render the block and its controls in the editor
* Here is where you will use core Gutenberg components for things like BlockControls to provide your alignment buttons, or the RichText component to enter and display text content
* Save function - Everything you need to display the block on the front-end
* This in no way needs to match what’s outputted by the save function. You could have a block that has a simple form-based input UI on the back-end, which renders its data in a much more stylized component on the front-end.
* But Gutenberg principles encourage as much parity as possible

## What about DYNAMIC BLOCKS?

* Many of the same principles and pieces
* The crucial difference is that instead of rendering  the block content on the front-end using a save function in the JS, it fetches its content on the server via PHP
* This is actually a much more powerful and I daresay more WordPressy way of doing things
* Basically required for server-side rendering
* Almost eliminates the problem of block content conflicts (and the need to resolve them in the editor)
* A much lower barrier for entry for back-end engineers because the content is now rendered in a more traditional WordPress manner via PHP

### ANATOMY OF A DYNAMIC BLOCK

In the PHP, we’re still registering a block script and providing it with its dependencies and optional stylesheets

But now, when registering the block type, we give it an additional argument render_callback

This render_callback function replaces the JS save function of a static block

This lets you do things like fetch content via WordPress functions — anything that can be rendered via WordPress can be part of your block content

Technically, in a static block you could use the REST API to do similar things, but in that case the block content is still stored as a static HTML string. So if you try to show latest posts, you will see a content conflict every time a new post is published

With a dynamic block you’re dynamically generating the content on render

CSS is the same as a static block, so no differences there

The JS is a bit simpler now.

* You still need your registerBlockType invocation with ID and config object
* You still need your meta info and edit function
* Your edit function still renders via JS
* But now there’s no save function, and this means you can change the edit function output as much as you want without having to worry about content conflicts
* You can still provide editor controls for content and attributes, for example you can provide a RichText field in the editor which allows editors to enter their own content, but fetching and rendering that content in your render_callback in the PHP
* If you want server-side rendering, you need to start with dynamic blocks

## BONUS: BLOCK STYLE VARIATIONS

Just something cool I started working with on a client project recently

This allows you to register custom style variations for any block, or unregister default style variations from core

Each variation is defined with a name which is added to the block wrapper element with an “is-style” prefix

So this “button-secondary” block gets a class name “is-style-button-secondary” added to its wrapper

This gets really powerful, as you can imagine
