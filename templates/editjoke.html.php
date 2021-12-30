<?php if (empty($joke->id) || $userId == $joke->authorId) : ?>
    <form action="" method="post">
        <input type="hidden" name="joke[id]" value="<?= $joke->id ?? '' ?>">
        <label for="joketext">Type your joke here:
        </label>
        <textarea id="joketext" name="joke[joketext]" rows="3" cols="40"><?= $joke->joketext ?? '' ?> </textarea>
        <label for="joketext">Select the category (ies) for your joke :
        </label>
        <?php foreach ($categories as $category) : ?>
            <label cols="40"><?= $category->name ?></label>
            <?php if ($joke && $joke->hasCategory($category->id)) : ?>
                <input type="checkbox" checked name="category[]" value="<?= $category->id ?>" />
            <?php else : ?>
                <input type="checkbox" name="category[]" value="<?= $category->id ?>" />
            <?php endif; ?>
        <?php endforeach; ?>
        <input type="submit" name="submit" value="Save">
    </form>
<?php else : ?>
    <p>You may only edit jokes that you posted.</p>
<?php endif; ?>