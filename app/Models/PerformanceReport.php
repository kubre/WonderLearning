<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;
use Str;

class PerformanceReport extends Model
{
    use AsSource;

    public $incrementing = false;

    public $timestamps = false;

    public $fillable = [
        'admission_id',
        'division_id',
        'performance',
        'date_at',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'date',
    ];

    public static $templates = [
        'Playgroup' => [
            'Literacy skills' => [
                'Tells his or her name and age' => 'Needs Encouragement',
                'Answers simple questions' => 'Needs Encouragement',
                'Speaks clearly although may not be fully comprehensible' => 'Needs Encouragement',
                'Asks simple questions' => 'Needs Encouragement',
                'Speaks in two to three word sentences' => 'Needs Encouragement',
                'Initiates the conversation' => 'Needs Encouragement',
                'Recognizes the first letter of their own name' => 'Needs Encouragement',
            ],
            'Numerical Skills' => [
                'Identifies some shapes such as circle and square and triangle' => 'Needs Encouragement',
                'Understands and explores empty containers and full containers' => 'Needs Encouragement',
                'Recognizes and matches small quantities to the numbers 1 and 2 and 3' => 'Needs Encouragement',
                'Shows interest in numbers and recites them' => 'Needs Encouragement',
                'Can count along with help' => 'Needs Encouragement',
                'Recognizes numerals 1 to 10' => 'Needs Encouragement',
                'Uses some size words such as many' => 'Needs Encouragement',
                'Shows interests in patterns and sequences' => 'Needs Encouragement',
                'Classifies or sorts objects into simple groups such as by colours and size' => 'Needs Encouragement',
                'Understands the order of the day and begins to use some time words such as morning and night' => 'Needs Encouragement',
            ],
            'Cognitive skills' => [
                'Correctly names familiar colours' => 'Needs Encouragement',
                'Understands the idea of same and different' => 'Needs Encouragement',
                'Remembers parts of a story' => 'Needs Encouragement',
                'Sorts objects by shape and colour' => 'Needs Encouragement',
                'Completes age appropriate puzzles' => 'Needs Encouragement',
                'Recognizes and identifies common objects and pictures' => 'Needs Encouragement',
            ],
            'Gross motor Skills' => [
                'Walks up and down stairs with help' => 'Needs Encouragement',
                'Kicks and throws a big ball' => 'Needs Encouragement',
                'Runs and rides a tricycle' => 'Needs Encouragement',
                'Walks forward and backward' => 'Needs Encouragement',
                'Bends over without falling' => 'Needs Encouragement',
                'Helps put on and remove clothing' => 'Needs Encouragement',
            ],
            'Fine motor skills' => [
                'Easily handles small objects and turns a page in a book' => 'Needs Encouragement',
                'Copies circles and squares' => 'Needs Encouragement',
                'Traces some patterns' => 'Needs Encouragement',
                'Builds a tower with four or more blocks' => 'Needs Encouragement',
                'Screws and unscrews jar lids' => 'Needs Encouragement',
            ],
            'Listening skills' => [
                'Follows simple instructions' => 'Needs Encouragement',
                'Enjoys listening to stories repeatedly' => 'Needs Encouragement',
            ],
            'Socio Emotional skills' => [
                'Cooperates with their friends' => 'Needs Encouragement',
                'Takes turns' => 'Needs Encouragement',
                'Shows some problem solving skills' => 'Needs Encouragement',
                'Imitates parents and friends' => 'Needs Encouragement',
                'Shows affection for familiar family and friends' => 'Needs Encouragement',
                'Understands the idea of mine and his or hers' => 'Needs Encouragement',
                'Shows a wide range of emotions such as being sad or angry or happy or bored' => 'Needs Encouragement',
            ],
        ],
        'Nursery' => [
            'Literacy skills' => [
                'Knows some basic rules of grammar such as correctly using he and she' => 'Needs Encouragement',
                'Sings a song or says a poem from memory' => 'Needs Encouragement',
                'Tells stories' => 'Needs Encouragement',
                'Tells first and last name and age' => 'Needs Encouragement',
                'Tells you what he thinks is going to happen next in a book' => 'Needs Encouragement',
                'Speaks clearly using more complex sentences' => 'Needs Encouragement',
                'Writes his or her name' => 'Needs Encouragement',
            ],
            'Maths Skills' => [
                'Understands size shape and patterns' => 'Needs Encouragement',
                'Counts numbers verbally first forward then backward' => 'Needs Encouragement',
                'Recognizes numerals 1 to 20' => 'Needs Encouragement',
                'Identifies more and less of a quantity' => 'Needs Encouragement',
                'Understands one to one correspondence ie matching sets or knowing which group has four and which has five' => 'Needs Encouragement',
            ],
            'Cognitive Skills' => [
                'Names some colours and some numbers' => 'Needs Encouragement',
                'Understands the idea of counting' => 'Needs Encouragement',
                'Understands times of a day' => 'Needs Encouragement',
                'Remembers parts of a story' => 'Needs Encouragement',
                'Understands the idea of same and different' => 'Needs Encouragement',
                'Draws a person stick figure with 2 to 4 body parts' => 'Needs Encouragement',
                'Starts to copy some capital letters' => 'Needs Encouragement',
                'Plays board games' => 'Needs Encouragement',
                'Understands everyday things like food and clothes' => 'Needs Encouragement',
            ],
            'Listening skills' => [
                'Follows two to three part commands' => 'Needs Encouragement',
                'Enjoys listening to stories' => 'Needs Encouragement',
            ],
            'Gross motor skills' => [
                'Hops and stands on one foot up to 2 seconds' => 'Needs Encouragement',
                'Catches a bounced ball most of the time' => 'Needs Encouragement',
                'Pours or cuts with supervision and mashes own food' => 'Needs Encouragement',
                'Can move rhythmically to music' => 'Needs Encouragement',
            ],
            'Fine Motor Skills' => [
                'Copies a triangle and circle and square and other shapes' => 'Needs Encouragement',
                'Draws a person with a body' => 'Needs Encouragement',
                'Stacks 10 or more blocks' => 'Needs Encouragement',
                'Uses a fork and spoon' => 'Needs Encouragement',
                'Dresses and undresses or brushes teeth and uses the toilet without much help' => 'Needs Encouragement',
            ],
            'Socio emotional Skills' => [
                'Enjoys playing with other children' => 'Needs Encouragement',
                'Shares and takes turns at least most of the time and understands rules of games' => 'Needs Encouragement',
                'Understands and obeys rules' => 'Needs Encouragement',
                'Is becoming more independent' => 'Needs Encouragement',
                'Expresses anger verbally rather than physically' => 'Needs Encouragement',
            ],
        ],
        'Junior KG' => [
            'Literacy skills' => [
                'Enjoys and recites rhymes and songs' => 'Needs Encouragement',
                'Comprehends spoken English' => 'Needs Encouragement',
                'Differentiates between soft and loud sounds' => 'Needs Encouragement',
                'Identifies and associates letters with the pictures' => 'Needs Encouragement',
                'Has clarity in Speech' => 'Needs Encouragement',
                'Understands stories and comprehends all the elements' => 'Needs Encouragement',
                'Can write letters with correct formation' => 'Needs Encouragement',
                'Writes two and three letter words' => 'Needs Encouragement',
            ],
            'Numerical Skills' => [
                'Recognizes objects and shapes and size and colour' => 'Needs Encouragement',
                'Identifies simple patterns' => 'Needs Encouragement',
                'Is able to do oral counting 1 to 20 or 1 to 50' => 'Needs Encouragement',
                'Can do backward counting' => 'Needs Encouragement',
                'Can count and match the numbers' => 'Needs Encouragement',
                'Is able to understand objects against the number' => 'Needs Encouragement',
            ],
            'Cognitive skills' => [
                'Draws with ease' => 'Needs Encouragement',
                'Moulds clay and make simple shapes' => 'Needs Encouragement',
                'Experiments with colours' => 'Needs Encouragement',
                'Expresses thoughts through drawing' => 'Needs Encouragement',
                'Expresses through role play' => 'Needs Encouragement',
                'Understands everyday things like food and clothes' => 'Needs Encouragement',
            ],
            'Gross motor Skills' => [
                'Understands eye and hand coordination' => 'Needs Encouragement',
                'Can walk on straight curved or zig zag lines' => 'Needs Encouragement',
                ' Is able to crawl or climb or kick' => 'Needs Encouragement',
                'Can move rhythmically to music' => 'Needs Encouragement',
                'Catches a bounced ball most of the time' => 'Needs Encouragement',
                'Pours and cuts with supervision and mashes own food' => 'Needs Encouragement',
            ],
            'Fine motor skills ' => [
                'Understands eye and hand coordination' => 'Needs Encouragement',
                'Knows his or her dominant hand' => 'Needs Encouragement',
                'Manipulates zippers or buttons' => 'Needs Encouragement',
                'Can hold and use pencil or crayon' => 'Needs Encouragement',
                'Is able to tear and paste paper' => 'Needs Encouragement',
                'Can trace lines curves accurately' => 'Needs Encouragement',
                'Can use scissors carefully' => 'Needs Encouragement',
            ],
            'Listening skills' => [
                'Understands stories and comprehends all the elements' => 'Needs Encouragement',
                'Comprehends spoken English' => 'Needs Encouragement',
                'Differentiates between soft and loud sounds' => 'Needs Encouragement',
            ],
            'Socio Emotional skills' => [
                'Shares and takes care of his or her toys or belongings' => 'Needs Encouragement',
                ' Interacts with classmates' => 'Needs Encouragement',
                'Follow class rules or commands or instructions' => 'Needs Encouragement',
                'Participates actively in all the activities' => 'Needs Encouragement',
                'Is imaginative' => 'Needs Encouragement',
                'Expresses emotions appropriately' => 'Needs Encouragement',
            ],
        ],
        'Senior KG' => [
            'Literacy skills' => [
                'Comprehends phonics' => 'Needs Encouragement',
                'Recognizes and differentiates between capital and small letters' => 'Needs Encouragement',
                'Can write letters with correct formation' => 'Needs Encouragement',
                'Attempts to form words or make sentences' => 'Needs Encouragement',
                'Is able to read sentences and understand' => 'Needs Encouragement',
                'Can narrate a story' => 'Needs Encouragement',
                'Understands stories and comprehends all the elements' => 'Needs Encouragement',
                'Recognizes hindi Swar or Vyanjans' => 'Needs Encouragement',
                'Reads three or four letter words' => 'Needs Encouragement',
            ],
            'Numerical Skills' => [
                'Can do oral counting 1 to 100' => 'Needs Encouragement',
                'Can do backward counting' => 'Needs Encouragement',
                'Can count and match the numbers' => 'Needs Encouragement',
                'Is able to understand objects against the number' => 'Needs Encouragement',
                'Can read and write the number names' => 'Needs Encouragement',
                'Can put numbers under the place value ones or tens or hundred' => 'Needs Encouragement',
                'Is able to understand and perform simple addition & subtraction' => 'Needs Encouragement',
                'Knows and understands the concept of time' => 'Needs Encouragement',
                'Can do skip counting' => 'Needs Encouragement',
            ],
            'Cognitive skills' => [
                'Draws with ease' => 'Needs Encouragement',
                'Moulds clay and makes complex shapes' => 'Needs Encouragement',
                'Experiments with colours' => 'Needs Encouragement',
                'Express thoughts through drawing' => 'Needs Encouragement',
            ],
            'Gross motor Skills' => [
                'Participates in various races and games' => 'Needs Encouragement',
                'Can hop and jump with ease' => 'Needs Encouragement',
                'Does backward running' => 'Needs Encouragement',
                'Can do basic exercises and stretching' => 'Needs Encouragement',
            ],
            'Fine motor skills' => [
                'Understands eye and hand coordination' => 'Needs Encouragement',
                'Knows his or her dominant hand' => 'Needs Encouragement',
                'Manipulates zippers or buttons' => 'Needs Encouragement',
                'Can hold and use pencil crayon' => 'Needs Encouragement',
                'Is able to write on four lines' => 'Needs Encouragement',
                'Can trace lines and curves accurately' => 'Needs Encouragement',
                'Can use scissors carefully' => 'Needs Encouragement',
            ],
            'Listening skills' => [
                'Listens and Sings familiar tunes' => 'Needs Encouragement',
                'Talks about music or rhymes that he or she listens to' => 'Needs Encouragement',
                'Shows interest in using instruments to produce sounds' => 'Needs Encouragement',
                'Uses creativity in dance and moves' => 'Needs Encouragement',
            ],
            'Socio Emotional skills' => [
                'Participates actively in all the activities' => 'Needs Encouragement',
                'Is imaginative' => 'Needs Encouragement',
                'Express emotions appropriately' => 'Needs Encouragement',
                'Shares his or her personal things' => 'Needs Encouragement',
                'Is self confident' => 'Needs Encouragement',
                'Practices good hygiene' => 'Needs Encouragement',
                'Appears neat and clean' => 'Needs Encouragement',
                'Enjoys peer company' => 'Needs Encouragement',
            ],
        ],
    ];

    public function getPerformanceAttribute($value)
    {
        $report = \json_decode($value, true);

        if (\is_null($report) || Str::length($value) < 50) {
            return static::$templates[$this->admission->program];
        }

        return $report;
    }

    public function getIsCorruptedAttribute()
    {
        return isset($this->attributes['performance']) && is_string($this->attributes['performance']) && Str::length($this->attributes['performance']) < 50;
    }

    public function getMonthAttribute()
    {
        return \substr($this->attributes['date_at'], 3, 3);
    }

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
