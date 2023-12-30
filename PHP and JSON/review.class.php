<?php
class PostReview {
    private $storage = "./Data/reviews.json";
    private $reviewsStorage = array();
    private $newReviews;
    private $postID;
    private $review;
    private $success;
    private $error;

    public function __construct($postID = null, $review = null) {
        $this->postID = $postID;
        $this->review = $review;

        // Check if the file exists, not $this->reviewsStorage
        if (file_exists($this->storage)) {
            $this->reviewsStorage = json_decode(file_get_contents($this->storage), true);
        }

        // Fix the structure of $this->newReviews
        $this->newReviews = [
            "postID" => [
                [
                    "review" => $this->review // Use $this->review directly as it's an array
                ]
            ]
        ];

        $this->updateReviews();
    }

    private function updateReviews() {
        // Append the new review to the existing reviews for the postID
        if (isset($this->reviewsStorage[$this->postID])) {
            $this->reviewsStorage[$this->postID][] = ["review" => $this->review];
        } else {
            // If no reviews for this postID yet, create a new array
            $this->reviewsStorage[$this->postID] = [["review" => $this->review]];
        }

        // Update the file with the modified reviewsStorage
        if (file_put_contents($this->storage, json_encode($this->reviewsStorage, JSON_PRETTY_PRINT))) {
            $this->success = "Review Posted!";
        } else {
            $this->error = "Something went wrong while updating the reviews, please try again";
        }
    }
    
    public function getEventsData(){
        if(file_exists($this->reviewsStorage)){
            $this->reviewsStorage = json_decode(file_get_contents($this->reviewsStorage), true);
        }
        return $this->reviewsStorage;
    }
}
?>
