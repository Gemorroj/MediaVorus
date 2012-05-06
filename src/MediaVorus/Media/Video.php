<?php

/*
 * This file is part of MediaVorus.
 *
 * (c) 2012 Romain Neutron <imprec@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MediaVorus\Media;

/**
 *
 * @author      Romain Neutron - imprec@gmail.com
 * @license     http://opensource.org/licenses/MIT MIT
 */
class Video extends Image
{
    protected $ffprobe;
    protected $duration;

    public function __construct($file, FileEntity $entity = null)
    {
        parent::__construct($file, $entity);

        $this->ffprobe = \FFMpeg\FFProbe::load();
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return self::TYPE_VIDEO;
    }

    /**
     * Get the duration of the video in seconds, null if unavailable
     *
     * @return float
     */
    public function getDuration()
    {
        if ($this->duration) {
            return $this->duration;
        }

        $sources = array('Composite:Duration', 'Flash:Duration', 'QuickTime:Duration', 'Real-PROP:Duration');

        if (null !== $value = $this->findInSources($sources)) {
            return (float) $value;
        }

        $result = $this->ffprobe->probeFormat($this->file->getPathname());

        foreach (explode("\n", $result) as $line) {
            if (preg_match('/duration=([\d\.]+)/i', $line, $matches)) {
                return $this->duration = (float) $matches[1];
            }
        }

        return null;
    }

    /**
     * Returns the value of video frame rate, null if not available
     *
     * @return string
     */
    public function getFrameRate()
    {
        $sources = array('RIFF:FrameRate', 'RIFF:VideoFrameRate', 'Flash:FrameRate');

        if (null !== $value = $this->findInSources($sources)) {
            return $value;
        }

        if (null !== $value = $this->getEntity()->executeQuery('Track1:VideoFrameRate')) {
            return $value;
        }

        return null;
    }

    /**
     * Returns the value of audio samplerate, null if not available
     *
     * @return string
     */
    public function getAudioSampleRate()
    {
        $sources = array('RIFF:AudioSampleRate', 'Flash:AudioSampleRate');

        if (null !== $value = $this->findInSources($sources)) {
            return $value;
        }

        if (null !== $value = $this->getEntity()->executeQuery('Track2:AudioSampleRate')) {
            return $value;
        }

        return null;
    }

    /**
     * Returns the name of video codec, null if not available
     *
     * @return string
     */
    public function getVideoCodec()
    {
        $sources = array('RIFF:AudioSampleRate', 'Flash:VideoEncoding');

        if (null !== $value = $this->findInSources($sources)) {
            return $value;
        }

        if (null !== $value = $this->getEntity()->executeQuery('QuickTime:ComAppleProappsOriginalFormat')) {
            return $value;
        }
        if (null !== $value = $this->getEntity()->executeQuery('Track1:CompressorName')) {
            return $value;
        }
        if (null !== $value = $this->getEntity()->executeQuery('Track1:CompressorID')) {
            return $value;
        }

        return null;
    }

    /**
     * Returns the name of audio codec, null if not available
     *
     * @return string
     */
    public function getAudioCodec()
    {
        if ($this->getMetadatas()->containsKey('RIFF:AudioCodec')
            && $this->getMetadatas()->containsKey('RIFF:Encoding')
            && $this->getMetadatas()->get('RIFF:AudioCodec')->getValue()->asString() === '') {
            return $this->getMetadatas()->get('RIFF:Encoding')->getValue()->asString();
        }
        if ($this->getMetadatas()->containsKey('Flash:AudioEncoding')) {
            return $this->getMetadatas()->get('Flash:AudioEncoding')->getValue()->asString();
        }
        if (null !== $VideoCodec = $this->getEntity()->executeQuery('Track2:AudioFormat')) {
            return $VideoCodec;
        }

        return null;
    }
}
