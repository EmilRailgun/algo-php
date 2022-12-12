<?php

namespace algo;

include "Question.php";
include "Collection.php";

class QuestionList extends Collection
{
    /**
     * parse
     *
     * @param  mixed $path
     * @return QuestionList
     */
    public function parse($path): QuestionList
    {
        $contents = file_get_contents($path);
        $questionsList = explode('######', $contents);
        // $i = 1;
        array_shift($questionsList);
        foreach ($questionsList as $questions) {
            [$question, $answer] = explode('####', $questions);
            try {
                [$title, $content] = explode('?', "$question");
                [$index, $title] = explode('.', "$title");
            } catch (\Throwable $th) {
                // echo $i;
                [$index, $title, $content] = explode('.', $question);
            }
            // if ($i == 14 || $i == 26 || $i == 39) {
            //     [$index, $title, $content] =
            //         explode('.', $question);
            // } else {
            //     [$title, $content] = explode('?', "$question");
            //     [$index, $title] = explode('.', "$title");
            // }
            // $i++;
            $this->add(new Question($index, $title, $content, $answer));
        }
        return $this;
    }

    public function saveJson($path)
    {
        $json = json_encode($this->all());
        file_put_contents($path, $json);
    }
}
